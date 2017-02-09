<?php
/**
 * Allows the Climber to record a new route if it isn't in the database yet
 *
 * @author     Ross Nordstrom <ross.nordstrom@chalk1up.net>
 * @copyright  2011-2013 Chalk1Up <contact@chalk1up.net>
 */
require_once("./authenticate.php");
require_once('../database/TrainDatabase.php');
require_once('../database/Climber.php');
require_once('../database/Session.php');
require_once('../database/Gym.php');
require_once('../database/Route.php');

$db = new TrainDatabase();
$setter = new Setter();
if(!$setter->fromExisting($_SESSION['SetterId']) ) {
  // Somehow this isn't a valid Setter, or $_SESSION['SetterId'] isn't set
  print_r("Invalid setter");
  exit();
}
$today=date('Y-m-d');

$gym = new Gym();
if(!$gym->fromExisting($session->GymId,'','','')) {
  header("Location: ./routes.php?Info=".urlencode("Error create area: gym"));
  exit();
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
    <div data-role="page" id="home" data-theme="a">
      <div data-role="header">
        <h1>Create New Area</h1>
      </div>
      <div data-role="content">
        <div class="center-wrapper"><h2>Are you sure the area doesn't already exist?</h2></div>
        <h3>Is it one of these?</h3>
        <ul data-role="listview">
        <?
        $areas = $gym->getAreasByType('');
        foreach ($areas as $area) {
          $areaPic = $area->getPicture();
          ?>
          <li>
            <a data-transition="slide" href=<? echo "'./routes.php?areaId=$area->Id'";?> >
              <h4><? echo $area->Name; ?></h4>
              <image style="float:left" src=<? echo "'$areaPic->Thumb'"; ?> title=<? echo "'$areaPic->Caption'"; ?>>
            </a>
          </li>
          <?
        } // foreach(areas as area)
        ?>
        </ul>
        <h3 style="padding-top:20px">Otherwise, Create it:</h3>
        <form method="post" action="./insertArea.php" data-ajax="false" enctype="multipart/form-data">
          <input type="hidden" name="GymId" value=<?echo "'$gym->Id'";?>>
          <input type="hidden" name="Callback" value=<?echo "'./set.php'";?>>
          <div data-role="fieldcontain">
            <label for="Name">Name:</label>
            <input type="text" name="Name" id="Name" />
          </div>
          <div data-role="fieldcontain">
            <label for="pic">Picture:</label>
            <input name="pic" id="pic" type="file" accept="image/*" capture="camera">
          </div>
          <div class="ui-grid-a">
            <div class="ui-block-a">
              <input type="submit" value="OK" data-theme="b" data-rel="back" />
            </div>
            <div class="ui-block-b">
              <a href="#" data-role="button" data-rel="back">Cancel</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>