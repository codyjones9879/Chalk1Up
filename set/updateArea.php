<?php
/**
 * Takes area info from POST, and updates that area
 *
 * @author     Ross Nordstrom <ross.nordstrom@chalk1up.net>
 * @copyright  2011-2013 Chalk1Up <contact@chalk1up.net>
 */
require_once("./authenticate.php");
require_once('../database/TrainDatabase.php');
require_once('../database/Climber.php');
require_once('../database/Session.php');
require_once('../database/Route.php');
require_once('../database/Gym.php');
require_once('../database/Picture.php');

$db = new TrainDatabase();

// Construct the area object
$area = new area();
if($area->fromExisting($_POST['AreaId'])) {
  // New name
  if($_POST['Name']) {
    $area->Name = $_POST['Name'];
    $area->update();
  }

  // If they uploaded a Picture, check it and resize for a area Picture
  if ((($_FILES["pic"]["type"] == "image/gif")
        || ($_FILES["pic"]["type"] == "image/png")
        || ($_FILES["pic"]["type"] == "image/jpg")
        || ($_FILES["pic"]["type"] == "image/jpeg")
        || ($_FILES["pic"]["type"] == "image/pjpeg"))) {
    if ($_FILES["pic"]["error"] == 0) {
      $picture = new Picture();
      $ext=strtolower(pathinfo($_FILES["pic"]["name"], PATHINFO_EXTENSION));
      if(move_uploaded_file($_FILES["pic"]["tmp_name"], $_FILES["pic"]["tmp_name"].".$ext") ) {
        $area->PicId = $picture->newAreaPicture($_FILES["pic"]["tmp_name"].".$ext", "$area->Name");
        $area->update();
      }
    }
  }

  // Return to the previous page
  if($_POST['Callback']) {
    // Return to the Callback page
    $url = $_POST['Callback'];
  } else {
    $url = "./areas.php?grade=$area->Grade";
  }
} else {
  $url = "./set.php";
}
header("Location: $url");
ob_end_flush();
?>