<?php
/**
 * Allows the Setter to create a new Route
 *
 * @author     Ross Nordstrom <ross.nordstrom@chalk1up.net>
 * @copyright  2011-2013 Chalk1Up <contact@chalk1up.net>
 */
require_once("./authenticate.php");
require_once('../database/TrainDatabase.php');
require_once('../database/Climber.php');
require_once('../database/Setter.php');
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
$defaultExpDate=date('Y-m-d', strtotime("+28 days"));

$gym = new Gym();
if(!$gym->fromExisting($setter->GymId)) {
  header("Location: ./routes.php?Info=".urlencode("Error create route: gym"));
  exit();
}

$route = new Route();

$area = new Area();
if($area->fromExisting($_GET['AreaId']) || $area->GymId!=$gym->Id) {
  $route->AreaId = $area->Id;
}
$route->GymId = $gym->Id;
$route->Grade = $_GET['Grade'];
$possibleMatches = $route->getPossibleMatches();
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
      <div data-role="header" data-theme="c">
        <h1>Create New Route</h1>
      </div>
      <div data-role="content">
        <form method="post" action="./insertRoute.php" data-ajax="false" enctype="multipart/form-data">
          <input type="hidden" name="GymId" value=<?echo "'$gym->Id'";?>>
          <input type="hidden" name="Callback" value=<?echo "'./set.php'";?>>
          <div data-role="fieldcontain">
            <label for="Grade">Grade:</label>
            <select required="required" id="Grade" name="Grade">
              <option>Select...</option>
              <?
                $grades = array_merge($db->getBoulderGrades(), $db->getRopeGrades());
                foreach ($grades as $grade) {
                  if(strcmp($_GET['Grade'],$grade)==0) {
                  echo "<option selected='selected' value='$grade'>$grade</option>";
                  } else {
                  echo "<option value='$grade'>$grade</option>";
                  }
                }
              ?>
            </select>
          </div>
          <div data-role="fieldcontain">
            <label for="AreaId">Area:</label>
            <select required="required" id="AreaId" name="AreaId">
              <option>Select...</option>
              <?
                $areas = $gym->getAreasByType('');
                foreach ($areas as $area) {
                  if($_GET['AreaId']==$area->Id) {
                    echo "<option selected='selected' value='$area->Id'>$area->Name</option>";
                  } else {
                    echo "<option value='$area->Id'>$area->Name</option>";
                  }
                }
              ?>
            </select>
          </div>
          <div data-role="fieldcontain">
            <label for="colorchoices">Color(s):</label>
            <div id="colorchoices" data-role="fieldcontain" class="ui-grid-b">
              <div class="ui-block-a">
                <select name="color1" id="color1">
                  <option value="">1st</option>
                  <?
                    $colorList = array('Pink','Red','Orange','Yellow','Mustard','Lime','Green','Forest','Teal','Blue','Navy','Purple','Brown','White','Silver','Grey','Black');

                    foreach ($colorList as $color) {
                      ?>
                      <option value=<? echo "'$color'"; ?>><? echo "$color"; ?></option>
                      <?
                    }
                  ?>
                </select>
              </div>
              <div class="ui-block-b">
                <select name="color2" id="color2">
                  <option value="">2nd</option>
                  <?
                    foreach ($colorList as $color) {
                      ?>
                      <option value=<? echo "'$color'"; ?>><? echo "$color"; ?></option>
                      <?
                    }
                  ?>
                </select>
              </div>
              <div class="ui-block-c">
                <select name="color3" id="color3">
                  <option value="">3rd</option>
                  <?
                    foreach ($colorList as $color) {
                      ?>
                      <option value=<? echo "'$color'"; ?>><? echo "$color"; ?></option>
                      <?
                    }
                  ?>
                </select>
              </div>
            </div>
          </div>
          <input type="text" name="color" placeholder="Or Custom Color" max="60" />
          <div data-role="fieldcontain">
            <label for="SetterId">Set By:</label>
            <select id="SetterId" name="SetterId">
              <option value="-1">Unknown</option>
              <?
                $setters = $gym->getSetters();
                foreach ($setters as $s) {
                  if($s->Id == $setter->Id) {
                    echo '<option selected value="'.$s->Id.'">'.$s->Name.'</option>'; 
                  } else {
                    echo '<option value="'.$s->Id.'">'.$s->Name.'</option>';
                  }
                }
              ?>
            </select>
            <input type="text" id="SetterName" name="SetterName" placeholder="Or Unlisted Setter" />
          </div>
          <div data-role="fieldcontain">
            <label for="Theme">Route Theme:</label>
            <select id="Theme" name="Theme">
              <option value="">Unknown</option>
              <?
                $themes = $gym->getThemes();
                foreach ($themes as $theme) {
                  echo "<option value='$theme'>$theme</option>";
                }
              ?>
            </select>
          </div>
          <div data-role="fieldcontain">
            <label for="Moves">Moves:</label>
            <input type="range" name="Moves" value="0" id="Moves" min="0" max="50" />
          </div>
          <div data-role="fieldcontain">
            <label for="SetDate">Set Date:</label>
            <input required="required" type="date" name="SetDate" value=<? echo "'$today'"; ?> max=<? echo "'$today'"; ?> />
          </div>
          <div data-role="fieldcontain">
            <label for="ExpDate">Expiration Date:</label>
            <input required="required" type="date" name="ExpDate" value=<? echo "'$defaultExpDate'"; ?>  min=<? echo "'$today'"; ?> />
          </div>
          <div data-role="fieldcontain">
            <label for="pic">Picture:</label>
            <input name="pic" id="pic" type="file" accept="image/*" capture="camera">
          </div>
          <div data-role="fieldcontain">
            <label for="Description">Description:</label>
            <textarea id="Description" maxlength="600" name="Description" placeholder="Describe the route (max 600 chars)..." ></textarea>
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