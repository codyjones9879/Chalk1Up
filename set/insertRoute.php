<?
/**
 * Inserts a new Route into the database
 *
 * @author     Ross Nordstrom <ross.nordstrom@chalk1up.net>
 * @copyright  2011-2013 Chalk1Up <contact@chalk1up.net>
 */
require_once('./authenticate.php');
require_once('../database/Climber.php');
require_once('../database/Setter.php');
require_once('../database/Gym.php');
require_once('../database/Session.php');
require_once('../database/Picture.php');

$db = new TrainDatabase();
$setter = new Setter();
if(!$setter->fromExisting($_SESSION['SetterId']) ) {
  // Somehow this isn't a valid Setter, or $_SESSION['SetterId'] isn't set
  print_r("Invalid setter");
  exit();
}
$today=date('Y-m-d');
$url = $_POST['Callback'] ? $_POST['Callback'] : "./routes.php?Info=".urlencode("Route created!");

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

// Require Gym, Area, Grade, Color, and SetDate to insert a new Route
if($_POST['GymId'] && $_POST['AreaId'] && $_POST['Grade'] && ($_POST['color'] || $_POST['color1']) && $_POST['SetDate']) {
  // Set up the Color
  if($_POST['color']) {
    $color = ucwords(strtolower($_POST['color']));
  } else {
    $color=$_POST['color1'];
    $color2=$_POST['color2'];
    $color3=$_POST['color3'];
    if($color2) {
      $color .= "/$color2";
    }
    if($color3) {
      $color .= "/$color3";
    }
  }

  $route = new Route();
  $route->GymId = $_POST['GymId'];
  $route->AreaId = $_POST['AreaId'];
  $route->SetterId = $_POST['SetterId'];
  $route->PicId = $_POST['PicId'];
  $route->SetDate = $_POST['SetDate'];
  $route->ExpDate = date('Y-m-d', strtotime(date('Y-m-d', strtotime($route->SetDate))."+30 days"));
  $route->Grade = $_POST['Grade'];
  $route->Color = $color;
  $route->Type = $_POST['Type'];
  $route->Theme = $_POST['Theme'];
  $route->Moves = $_POST['Moves'];
  $route->Description = $_POST['Description'];

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
        $area = $route->getArea();
        $gym = $route->getGym();
        $route->PicId = $picture->newRoutePicture($_FILES["pic"]["tmp_name"].".$ext", date("Y-m-d",strtotime($route->SetDate)).": $route->Grade $route->Color @ $area->Name, $gym->Name");
      }
    }
  }

  $route->create();
  if(strpos($url, "route.php")) {
    // Redirect them to the newly created route
    $url = "./route.php?RouteId=$route->Id";
  }
} else {
  // Invalid route, send them back
  $url = $_SERVER['HTTP_REFERER'];
}

header("Location: $url");
?>