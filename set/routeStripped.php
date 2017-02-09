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
$setter = new Setter();
if(!$setter->fromExisting($_SESSION['SetterId']) ) {
  // Somehow this isn't a valid Setter, or $_SESSION['SetterId'] isn't set
  print_r("Invalid setter");
  exit();
}
$today=date('Y-m-d');
// Construct the route object
$route = new route();
if($route->fromExisting($_GET['RouteId'])) {
  $route->StripDate = $_GET['StripDate'];
  $route->update();

  // Defaults
  $to = "contact@chalk1up.net";
  $strippedBy = "Unknown";

  $climber = new Climber();
  $s = new Setter();
  if($s->fromExisting($route->SetterId)) {
    $strippedBy = $s->Name;
    if($climber->fromExisting($s->ClimberId)) {
      $to = $climber->Email;
    }
  }
  $area = $route->getArea();
  $rating = $route->getRating();
  $comment = $_GET['Comment'] ? "Comment from stripper (not that kind):
  ".$_GET['Comment'] : "[No comments from stripper]";

  // Notify the Setter that the route was stripped
  $from="contact@chalk1up.net";
  $subject = "[Chalk1Up] Route Stripped";
  $msg = "Route stripped by $strippedBy
          $route->Grade $route->Color @ $area->Name
          
          Final rating was: $rating/5

          $comment

          Regards,
          The Chalk1Up Team
          http://set.chalk1up.net";
  $db->sendEmail($to,$from,$subject,$msg);

  // Return to the previous page
  if($_GET['Callback']) {
    // Return to the Callback page
    $url = $_GET['Callback'];
  } else {
    $url = "./feed";
  }
} else {
  $url = "./feed.php";
}
header("Location: $url");
ob_end_flush();
?>