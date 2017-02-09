<?php
/**
 * Deletes Send from the database
 *
 * @author     Ross Nordstrom <ross.nordstrom@chalk1up.net>
 * @copyright  2011-2013 Chalk1Up <contact@chalk1up.net>
 */
require_once("./authenticate.php");
require_once('../database/TrainDatabase.php');
require_once('../database/Climber.php');
require_once('../database/Session.php');
require_once('../database/Send.php');
require_once('../database/Gym.php');
require_once('../database/Picture.php');

$url = $_GET['Callback'] ? $_GET['Callback'] : "./feed.php";
$route = new Route();
if($route->fromExisting($_GET['RouteId'])) {
  $route->delete();
} else {
  $url .= "?Info=".urlencode("Error - Invalid Send");
}

header("Location: $url");
?>