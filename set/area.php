<?php
/**
 * Lets user edit or delete area
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
$gym->fromExisting($session->GymId,'','','');

$area = new Area();
if ($area->fromExisting($_GET['AreaId'])) {
  $areaPic = $area->getPicture();
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
        <? if($area) { ?>
          <h1><? echo $area->Name; ?></h1>
        <? } else { ?>
          <h1>Error: Invalid Area</h1>
        <? } ?>
      </div>
      <div data-role="content">
        <? if($area) { ?>
          <image style="width:100%" src=<? echo "'$areaPic->Pic'"; ?> title=<? echo "'$areaPic->Caption'"; ?>/>
          <h3><? echo $areaPic->Caption; ?></h3>
          <form action="./updateArea.php" method="post" data-ajax="false" data-rel="dialog" enctype="multipart/form-data">
            <h2>Edit Area:</h2>
            <input type="hidden" name="AreaId" value=<?echo "'$area->Id'"; ?> >
            <input type="hidden" name="Callback" value=<?echo "'./area.php?AreaId=$area->Id'"; ?> >
            <div data-role="fieldcontain">
              <label for="Name">New Name:</label>
              <input type="text" id="Name" name="Name" />
            </div>
            <div data-role="fieldcontain">
              <label for="pic">New Picture:</label>
              <input name="pic" id="pic" type="file" accept="image/*" capture="camera">
            </div>
            <div class="ui-grid-a">
              <div class="ui-block-a">
                <input type="submit" value="Update" data-theme="b" data-rel="back" />
              </div>
              <div class="ui-block-b">
                <a href="#" data-role="button" data-rel="back">Cancel</a>
              </div>
            </div>
          </form>
        <? } // if($area) ?>
      </div>
    </div>
  </body>
</html>