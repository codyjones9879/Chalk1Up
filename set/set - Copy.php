<?php
/**
 * Setter's portal. The setter can choose to set a route
 * by grade or area, and boulder or rope here.
 *
 * @author     Ross Nordstrom <ross.nordstrom@chalk1up.net>
 * @copyright  2011-2013 Chalk1Up <contact@chalk1up.net>
 */
$_SESSION['TargetURL'] = "./set.php";
require_once("./authenticate.php");
require_once('../database/TrainDatabase.php');
require_once('../database/Climber.php');
require_once('../database/Session.php');
require_once('../database/Gym.php');
require_once('../database/Picture.php');

$db = new TrainDatabase();
// Set up this Setter
$climber = new Climber();
if(!$climber = $climber->fromExisting($_SESSION['Id'])) {
  // Somehow this isn't a valid Climber, or $_SESSION['SetterId'] isn't set
  print_r("Invalid climber");
  exit();
}
$today=date('Y-m-d');

$gym = new Gym();
$gym->fromExisting($setter->GymId);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Set a Route</title>
    <? include 'head1.html'; ?>
    <script src="./climb.js"></script>
    <? include 'head2.html'; ?>
  </head>
  <body>
    <div id="set" data-role="page" id="home" data-theme="c">
      <? include 'navbar.php'; ?>
      <div data-role="content" align="center">
        <? if($_GET['Info']) { ?>
          <div class="ui-btn-right ui-bar-d" data-role="button" data-icon="info">
            <? echo $_GET['Info']; ?>
          </div>
        <? } ?>
          <div style="display:none" class="center-wrapper refreshToShow">
            <fieldset data-role="controlgroup" data-type="horizontal" >
              <input type="radio" name="climb_type" id="type_b" value="boulder" checked="checked" />
              <label for="type_b">Boulder</label>

              <input type="radio" name="climb_type" id="type_tr" value="toprope"  />
              <label for="type_tr">Rope</label>
            </fieldset>
            <fieldset data-role="controlgroup" data-type="horizontal" >
              <input type="radio" name="route_type" id="type_grade" value="grade" checked="checked" />
              <label for="type_grade">Grade</label>

              <input type="radio" name="route_type" id="type_area" value="area"  />
              <label for="type_area">Area</label>
            </fieldset>
          </div>
          <p class="refreshInfo">Please refresh your browser! <a data-role="button" href="javascript:document.location.reload();">Refresh</a></p>
          <div class="center-wrapper boulder_grades">
            <h2>Select a Grade to Set:</h2>
            <?
            $grades = $db->getBoulderGrades();
            $i=0;
            foreach ($grades as $grade) {
              if($i==0) {
                $divOpen = true;
                ?>
                <div data-role="controlgroup" data-type="horizontal">
              <? } ?>
              <a href=<?echo "'./routes.php?grade=$grade'&Type=Boulder";?> data-role="button" data-rel="" data-transition="slide"><?echo $grade;?></a>
              <?
              $i = ($i+1)%3;  // Group grades in sets of 3
              if($i==0) {
                $divOpen = false;
                ?>
                </div><br>
              <?
              }
            } // foreach grades as grade
            // In case the number of grades doesn't divide evenly by 3, make sure to close the last controlgroup
            if($divOpen) { ?>
              </div>
            <? } ?>
          </div>
          <div style="display:none" class="center-wrapper rope_grades">
            <h2>Select a Grade to Set:</h2>
            <?
              $grades = $db->getRopeGrades();
              $i=0;
              foreach ($grades as $grade) {
                if($i==0) {
                  $divOpen = true;
                  ?>
                  <div data-role="controlgroup" data-type="horizontal">
                <? } ?>
                <a href=<?echo "'./routes.php?grade=$grade'&Type=Rope";?> data-role="button" data-rel="" data-transition="slide">
                  <?echo $grade;?>
                </a>
                <?
                $i = ($i+1)%3;  // Group grades in sets of 3
                if($i==0) {
                  $divOpen = false;
                  ?>
                  </div><br>
                <? }
              }
              // In case the number of grades doesn't divide evenly by 3, make sure to close the last controlgroup
              if($divOpen) { ?>
                </div>
              <? }
            ?>
          </div>
          <h2 style="display:none" class="boulder_areas">Select an Area to Set:</h2>
          <ul style="display:none" class="boulder_areas" data-role="listview">
            <?
            // Get the Boulder Areas in this gym.
            $boulderAreas = $gym->getAreasByType('Boulder');
            foreach ($boulderAreas as $area) {
              $areaPic = $area->getPicture();
              $boulderCount = $area->countProblemsByGrade($argGetAllGrades='');
              $setterRouteCount = $gym->getRouteCount($area->Id, $setter->Id, 'Boulder');
              $routeCount = $gym->getRouteCount($area->Id, null, 'Boulder');
              $rating = $area->getRating();
              ?>
              <li>
                <a href=<? echo "'./routes.php?areaId=$area->Id'&Type=Boulder"; ?> data-transition="slide" >
                  <image src=<? echo "'$areaPic->Thumb'"; ?> title=<? echo "'$areaPic->Caption'"; ?>/>
                  <h2><? echo $area->Name; ?></h2>
                  <p class="refreshInfo">Refresh for ratings!</p>
                  <input type="hidden" class=<? echo "'rating_star_$rating'";?> name="Rating" id="Rating">
                </a>
                <a data-icon="gear" href=<?echo "'./area.php?AreaId=$area->Id'"; ?> >
                </a>
                <span class="ui-li-count"><? echo "$setterRouteCount/$routeCount"; ?></span>
              </li>
            <? } // foreach(boulderAreas as area) ?>
            <li data-theme="e" data-icon="plus">
              <?
                $url = "./newArea.php";
              ?>
              <a href=<? echo "'$url'"; ?> data-transition="slide">
                <h2>New Area</h2>
                <p>Please confirm the area doesn't exist</p>
              </a>
            </li>
          </ul>
          <h2 style="display:none" class="rope_areas">Select an Area to Set:</h2>
          <ul style="display:none" class="rope_areas" data-role="listview">
            <?
            // Get the Boulder Areas in this gym.
            $ropeAreas = $gym->getAreasByType("Rope");
            foreach ($ropeAreas as $area) {
              $areaPic = $area->getPicture();
              $setterRouteCount = $gym->getRouteCount($area->Id, $setter->Id, 'Rope');
              $routeCount = $gym->getRouteCount($area->Id, null, 'Rope');
              $rating = $area->getRating();
              ?>
              <li>
                <a href=<? echo "'./routes.php?areaId=$area->Id'&Type=Rope"; ?> data-transition="slide" >
                  <image src=<? echo "'$areaPic->Thumb'"; ?> title=<? echo "'$areaPic->Caption'"; ?>/>
                  <h2><? echo $area->Name; ?></h2>
                  <p class="refreshInfo">Refresh for ratings!</p>
                  <input disabled="disabled" type="hidden" class=<? echo "'rating_star_$rating'";?> name="Rating" id="Rating">
                </a>
                <a data-icon="gear" href=<?echo "'./area.php?AreaId=$area->Id'"; ?> >
                </a>
                <span class="ui-li-count"><? echo "$setterRouteCount/$routeCount"; ?></span>
              </li>
            <? } // foreach(ropeAreas as area) ?>
            <li data-theme="e" data-icon="plus">
              <?
                $url = "./newArea.php";
              ?>
              <a href=<? echo "'$url'"; ?> data-transition="slide">
                <h2>New Area</h2>
                <p>Please confirm the area doesn't exist</p>
              </a>
            </li>
          </ul>
        </div>
      <? include 'footer.html'; ?>
    </div>
  </body>
</html>