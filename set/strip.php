<?php
/**
 * Lets user edit or delete comment
 *
 * @author     Ross Nordstrom <ross.nordstrom@chalk1up.net>
 * @copyright  2011-2013 Chalk1Up <contact@chalk1up.net>
 */
require_once("./authenticate.php");
require_once('../database/TrainDatabase.php');
require_once('../database/Climber.php');
require_once('../database/Setter.php');
require_once('../database/Comment.php');
require_once('../database/Picture.php');

$db = new TrainDatabase();
$setter = new Setter();
if(!$setter->fromExisting($_SESSION['SetterId']) ) {
  // Somehow this isn't a valid Setter, or $_SESSION['SetterId'] isn't set
  print_r("Invalid setter");
  exit();
}
$today=date('Y-m-d');

$gym = new Gym();
$gym->fromExisting($setter->GymId);

$route = new Route();
if ($route->fromExisting($_GET['RouteId'])) {
  $area = $route->getArea();
  $routePic = $route->getPicture();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Chalk1Up Mobile Trainer</title>
    <? include 'head1.html'; ?>
    <? include 'head2.html'; ?>
  </head>
  <body>
    <div data-role="page" id="home" data-theme="c">
      <div data-role="header" data-id="train-header" data-theme="c">
        <? if($route) { ?>
          <a href=<? echo "'./feed.php'"; ?> data-role="button" data-icon="arrow-l" data-transition="slide" data-direction="reverse">Feed</a>
          <h1>Strip Route</h1>
        <? } else { ?>
          <a href=<? echo "'./feed.php'"; ?> data-role="button" data-icon="arrow-l" data-transition="slide" data-direction="reverse">Feed</a>
          <h1>Error: Invalid Route</h1>
        <? } ?>
      </div>
      <div data-role="content">
        <? if($route) { ?>
          <h2>Strip Route?</h2>
          <form action="./confirmAction.php" method="get" data-ajax="false" data-rel="dialog">
            <input type="hidden" name="Action" value="./routeStripped.php">
            <input type="hidden" name="Info" value="Are you sure you want to mark this route as stripped?
                   It will no longer be available to send!">
            <input type="hidden" name="Callback" value=<? echo "'./feed.php'"; ?> >
            <input type="hidden" name="RouteId" value=<? echo "'$route->Id'"; ?>>
            <div data-role="fieldcontain">
              <label for="StripDate">Stripped Date:</label>
              <input required="required" type="date" name="StripDate" value=<? echo "'$today'"; ?> min=<? echo '"'.date("Y-m-d", strtotime($route->SetDate)).'"'; ?> max=<? echo "'$today'"; ?> />
            </div>
            <div data-role="fieldcontain">
              <label for="Comment">Comment:</label>
              <textarea id="Comment" name="Comment" placeholder="Comment about the route (i.e. 'Hold damaged' or 'Route is injury prone', etc.)" ></textarea>
            </div>
            <div class="ui-grid-a">
              <div class="ui-block-a">
                <input <? if(false) echo "disabled"; ?> type="submit" value="Strip" data-theme="b" data-rel="dialog" data-icon="delete"/>
              </div>
              <div class="ui-block-b">
                <a href="#" data-role="button" data-rel="back">Cancel</a>
              </div>
            </div>
          </form>
        <? } // if($route) ?>
      </div>
    </div>
  </body>
</html>