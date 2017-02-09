<?php
/**
 * Lets user pic an area and grade to set
 *
 * @author     Ross Nordstrom <ross.nordstrom@chalk1up.net>
 * @copyright  2011-2013 Chalk1Up <contact@chalk1up.net>
 */
$_GET['TargetURL'] = "./routes.php?grade=".$_GET['grade']."&areaId=".$_GET['areaId'];
require_once("./authenticate.php");
require_once('../database/TrainDatabase.php');
require_once('../database/Climber.php');
require_once('../database/Session.php');
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

$gym = new Gym();
$gym->fromExisting($setter->GymId);

if($_GET['Type']) {
  $type = $_GET['Type'];
}

if($_GET['grade']) {
  $grade = $_GET['grade'];
} else if($_GET['areaId']) {
  $area = new Area();
  if($area->fromExisting($_GET['areaId'], '','')) {
    $areaId = $area->Id;
    $areaPic = $area->getPicture();
  }
} else {
  $grade = "V0";  // Default to V0
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
        <a href="./set.php" data-role="button" data-icon="arrow-l" data-transition="slide" data-direction="reverse">Set</a>
        <? if($grade) { ?>
          <h1>Set a <?echo $grade;?></h1>
        <? } else { ?>
          <h1>Set in <?echo $area->Name;?></h1>
        <? } ?>
      </div>
      <div data-role="content">
        <p class="refreshInfo">Refresh for ratings! <a data-role="button" href="javascript:document.location.reload();">Refresh</a></p>
        <ul data-role="listview" data-theme="c">
          <? if($grade) { // if grade picked, show areas
            $areas = $gym->getAreasByType($type);
            foreach ($areas as $area) {
              $areaPic = $area->getPicture();
              $setterRouteCount = $gym->getRouteCount($area->Id, $setter->Id, $type, $grade);
              $routeCount = $gym->getRouteCount($area->Id, null, $type, $grade);
              $rating = $area->getRating($grade);
              ?>
              <li <? if(!$routeCount) { echo "data-theme='e'"; }?> >
                <a href=<?echo "'./newRoute.php?Grade=$grade&AreaId=$area->Id'"; ?> >
                  <h2><? echo $area->Name; ?></h2>
                  <p class="refreshInfo">Refresh for ratings!</p>
                  <input disabled="disabled" type="hidden" class=<? echo "'rating_star_$rating'";?> name="Rating" id="Rating">
                  <image src=<? echo "'$areaPic->Thumb'"; ?> title=<? echo "'$areaPic->Caption'"; ?>>
                </a>
                <span class="ui-li-count"><? echo "$setterRouteCount/$routeCount"; ?></span>
                <a data-theme="b" data-ajax="true" href=<?echo "'./area.php?AreaId=$area->Id'";?> data-icon="edit"></a>
              </li>
              <?
            } // foreach areas as area
          } else { // if area picked, show grades
            $grades = $db->getGrades($type);
            foreach ($grades as $grade) {
              $setterRouteCount = $gym->getRouteCount($area->Id, $setter->Id, $type, $grade);
              $routeCount = $gym->getRouteCount($area->Id, null, $type, $grade);
              $rating = $area->getRating($grade);
              ?>
              <li <? if(!$routeCount) { echo "data-theme='e'"; }?> data-icon="plus">
                <a data-ajax="true" href=<?echo "'./newRoute.php?Grade=$grade&AreaId=$area->Id'";?> >
                  <h2><? echo $grade; ?></h2>
                  <input disabled="disabled" type="hidden" class=<? echo "'rating_star_$rating'";?> name="Rating" id="Rating">
                </a>
                <span class="ui-li-count"><? echo "$setterRouteCount/$routeCount"; ?></span>
              </li>
              <?
            } // foreach grades as grade
          } // if area picked ?>
        </ul>
      </div>
      <? include 'footer.html'; ?>
    </div>
  </body>
</html>