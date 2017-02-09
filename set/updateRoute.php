<?php
/**
 * Takes route info from POST, and updates that route
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

if($_POST['SetterName']) {
  // They input an unlisted setter, create the setter
  $setter = new Setter();
  if($setter->fromExisting('',$_POST['SetterName'],$_POST['GymId'])) {
    $_POST['SetterId'] = $setter->Id;
  } else {
    $setter->ClimberId = 0;
    $setter->Name = $_POST['SetterName'];
    $setter->GymId = $_POST['GymId'];
    $setter->PicId = 1;
    $setter->Bio = "Added by $climber->Name";
    $setter->create();
    $_POST['SetterId'] = $setter->Id;
  }
}

// Construct the route object
$route = new route();
if($route->fromExisting($_POST['RouteId'])) {

  $color=$_POST['color1'];
  $color2=$_POST['color2'];
  $color3=$_POST['color3'];
  if($color2) {
    $color .= "/$color2";
  }
  if($color3) {
    $color .= "/$color3";
  }
  
  $route->GymId = $_POST['GymId'];
  $route->AreaId = $_POST['AreaId'];
  $route->SetterId = $_POST['SetterId'];
  $route->SetDate = $_POST['SetDate'];
  $route->ExpDate = $_POST['ExpDate'];
  $route->StripDate = $_POST['StripDate'];
  $route->Grade = $_POST['Grade'];
  $route->Color = $color;
  $route->Type = $_POST['Type'];
  $route->Theme = $_POST['Theme'];
  $route->Moves = $_POST['Moves'];
  $route->Description = $_POST['Description'];
  $route->Beta = $_POST['Beta'];

  // If they uploaded a Picture, check it and resize for a route Picture
  if ((($_FILES["pic"]["type"] == "image/gif")
        || ($_FILES["pic"]["type"] == "image/png")
        || ($_FILES["pic"]["type"] == "image/jpg")
        || ($_FILES["pic"]["type"] == "image/jpeg")
        || ($_FILES["pic"]["type"] == "image/pjpeg"))) {
    if ($_FILES["pic"]["error"] == 0) {
      $picture = new Picture();
      $ext=strtolower(pathinfo($_FILES["pic"]["name"], PATHINFO_EXTENSION));
      if(move_uploaded_file($_FILES["pic"]["tmp_name"], $_FILES["pic"]["tmp_name"].".$ext") ) {
        $route->PicId = $picture->newRoutePicture($_FILES["pic"]["tmp_name"].".$ext", "$route->Description");
      }
    }
  }
  $route->update();

  // Return to the previous page
  if($_POST['Callback']) {
    // Return to the Callback page
    $url = $_POST['Callback'];
  } else {
    $url = "./routes.php?grade=$route->Grade";
  }
} else {
  $url = "./routes.php";
}
header("Location: $url");
ob_end_flush();
?>