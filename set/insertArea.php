<?php
/**
 * Takes Area info from POST, and puts it into the database
 *
 * @author     Ross Nordstrom <ross.nordstrom@chalk1up.net>
 * @copyright  2011-2013 Chalk1Up <contact@chalk1up.net>
 */
require_once("./authenticate.php");
require_once('../database/TrainDatabase.php');
require_once('../database/Climber.php');
require_once('../database/Setter.php');
require_once('../database/Session.php');
require_once('../database/Area.php');
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

// Return to the previous page
if($_POST['Callback']) {
  // Return to the Callback page
  $url = $_POST['Callback'];
} else {
  $url = "./routes.php";
}

$gym = new Gym();
if($gym->fromExisting($setter->GymId)) {
  // Construct the Send object
  $area = new Area();
  $area->GymId = $gym->Id;
  $area->Name = $_POST['Name'];

  // If they uploaded a Picture, check it and resize for a Send Picture
  if ((($_FILES["pic"]["type"] == "image/gif")
        || ($_FILES["pic"]["type"] == "image/png")
        || ($_FILES["pic"]["type"] == "image/jpg")
        || ($_FILES["pic"]["type"] == "image/jpeg")
        || ($_FILES["pic"]["type"] == "image/pjpeg"))) {
    if ($_FILES["pic"]["error"] == 0) {
      $picture = new Picture();
      $ext=strtolower(pathinfo($_FILES["pic"]["name"], PATHINFO_EXTENSION));
      if(move_uploaded_file($_FILES["pic"]["tmp_name"], $_FILES["pic"]["tmp_name"].".$ext") ) {
        $area->PicId = $picture->newAreaPicture($_FILES["pic"]["tmp_name"].".$ext", "$area->Name, $gym->Name");
      }
    }
  }
  $area->create();
  $url .= "?Info=".urlencode("Area created: $area->Name");
}

header("Location: $url");
ob_end_flush();
?>