<?php
/**
 * Takes Forerun info from POST, and puts it into the database
 *
 * @author     Ross Nordstrom <ross.nordstrom@chalk1up.net>
 * @copyright  2011-2013 Chalk1Up <contact@chalk1up.net>
 */
require_once("./authenticate.php");
require_once('../database/TrainDatabase.php');
require_once('../database/Climber.php');
require_once('../database/Session.php');
require_once('../database/Forerun.php');
require_once('../database/Gym.php');
require_once('../database/Picture.php');

$db = new TrainDatabase();
$setter = new Setter();
if(!$setter->fromExisting($_SESSION['SetterId']) ) {
  // Somehow this isn't a valid Setter, or $_SESSION['SetterId'] isn't set
  print_r("Invalid setter");
  exit();
}
$today=date('Y-m-d');

$url = $_POST['Callback'] ? $_POST['Callback'] : "./feed.php";

// Construct the Forerun object
$forerun = new Forerun();
$route = new Route();
if($route->fromExisting($_POST['RouteId'])) {
  $forerun->RouteId = $route->Id;
  $forerun->Date = $today;
  $forerun->Rating = $_POST['Rating'];
  $forerun->SuggestedGrade = $_POST['SuggestedGrade'];
  $forerun->Comment = $_POST['Comment'];

  // If they uploaded a Picture, check it and resize for a Forerun Picture
  if ((($_FILES["pic"]["type"] == "image/gif")
        || ($_FILES["pic"]["type"] == "image/png")
        || ($_FILES["pic"]["type"] == "image/jpg")
        || ($_FILES["pic"]["type"] == "image/jpeg")
        || ($_FILES["pic"]["type"] == "image/pjpeg"))) {
    if ($_FILES["pic"]["error"] == 0) {
      $picture = new Picture();
      $ext=strtolower(pathinfo($_FILES["pic"]["name"], PATHINFO_EXTENSION));
      if(move_uploaded_file($_FILES["pic"]["tmp_name"], $_FILES["pic"]["tmp_name"].".$ext") ) {
        $forerun->PicId = $picture->newForerunPicture($_FILES["pic"]["tmp_name"].".$ext", "$forerun->Description");
        if ($route->PicId < 5) {
          // Use this Forerun's picture as the picture for the route
          $route->PicId = $forerun->PicId;
          $route->update();
        }
      }
    }
  }

  $forerun->create();
}

header("Location: $url");
ob_end_flush();
?>