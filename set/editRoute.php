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
          <!-- <a href=<? echo "'./feed.php'"; ?> data-role="button" data-icon="arrow-l" data-transition="slide" data-direction="reverse">Feed</a> -->
          <h1>Edit Route</h1>
        <? } else { ?>
          <!-- <a href=<? echo "'./feed.php'"; ?> data-role="button" data-icon="arrow-l" data-transition="slide" data-direction="reverse">Feed</a> -->
          <h1>Error: Invalid Route</h1>
        <? } ?>
      </div>
      <div data-role="content">
        <? if($route) { ?>
          <h2>Edit Route Details</h2>
          <image style="float:left; padding-right:10px;" src=<? echo "'$routePic->Thumb'"; ?>/>
          <h2><? echo "$author->Name $time"; ?></h2>
          <form method="post" action="./updateRoute.php" data-ajax="false" enctype="multipart/form-data">
            <input type="hidden" name="GymId" value=<?echo "'$gym->Id'";?>>
            <input type="hidden" name="RouteId" value=<?echo "'$route->Id'";?>>
            <input type="hidden" name="Callback" value=<?echo "'./feed.php'";?>>
            <div data-role="fieldcontain">
              <label for="Grade">Grade:</label>
              <select required="required" id="Grade" name="Grade">
                <option>Select...</option>
                <?
                  $grades = array_merge($db->getBoulderGrades(), $db->getRopeGrades());
                  foreach ($grades as $grade) {
                    if(strcmp($route->Grade,$grade)==0) {
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
                  foreach ($areas as $areaOption) {
                    if($area->Id==$areaOption->Id) {
                      echo "<option selected='selected' value='$areaOption->Id'>$areaOption->Name</option>";
                    } else {
                      echo "<option value='$areaOption->Id'>$areaOption->Name</option>";
                    }
                  }
                ?>
              </select>
            </div>
            <div data-role="fieldcontain">
              <label for="colorchoices">Color(s):</label>
              <?
                $colors = explode("/", $route->Color);
                $color1 = $colors[0];
                if(count($colors)>1) {
                  $color2 = $colors[1];
                  if(count($colors)>2) {
                    $color3 = $colors[2];
                  }
                }
              ?>
              <div id="colorchoices" data-role="fieldcontain" class="ui-grid-b">
                <div class="ui-block-a">
                  <select required="required" name="color1" id="color1">
                    <option value="">1st</option>
                    <?
                      $colorList = array('Pink','Red','Orange','Yellow','Mustard','Lime','Green','Forest','Teal','Blue','Navy','Purple','Brown','White','Silver','Grey','Black');

                      foreach ($colorList as $color) {
                        ?>
                        <option <? if(strcmp($color1, $color)==0) { echo "selected='selected'"; } ?> value=<? echo "'$color'"; ?>><? echo "$color"; ?></option>
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
                        <option <? if(strcmp($color2, $color)==0) { echo "selected='selected'"; } ?> value=<? echo "'$color'"; ?>><? echo "$color"; ?></option>
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
                        <option <? if(strcmp($color3, $color)==0) { echo "selected='selected'"; } ?> value=<? echo "'$color'"; ?>><? echo "$color"; ?></option>
                        <?
                      }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div data-role="fieldcontain">
              <label for="SetterId">Set By:</label>
              <select id="SetterId" name="SetterId">
                <option value="-1">Unknown</option>
                <?
                  $setters = $gym->getSetters();
                  foreach ($setters as $setter) {
                    if($route->SetterId == $setter->Id) {
                      echo '<option selected="selected" value="'.$setter->Id.'">'.$setter->Name.'</option>';
                    } else {
                      echo '<option value="'.$setter->Id.'">'.$setter->Name.'</option>'; 
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
                    if(strcmp($route->Theme,$theme)==0) {
                      echo "<option selected='selected' value='$theme'>$theme</option>";
                    } else {
                      echo "<option value='$theme'>$theme</option>";
                    }
                  }
                ?>
              </select>
            </div>
            <div data-role="fieldcontain">
              <label for="Moves">Moves:</label>
              <input type="range" name="Moves" value=<? echo "'$route->Moves'"; ?> id="Moves" min="0" max="50" />
            </div>
            <div data-role="fieldcontain">
              <label for="SetDate">Set Date:</label>
              <input required="required" type="date" value=<? echo '"'.date("Y-m-d", strtotime($route->SetDate)).'"'; ?> name="SetDate" max=<? echo "'$today'"; ?> />
            </div>
            <div data-role="fieldcontain">
              <label for="ExpDate">Expiration Date:</label>
              <input required="required" type="date" value=<? echo '"'.date("Y-m-d", strtotime($route->ExpDate)).'"'; ?> name="ExpDate" min=<? echo '"'.date("Y-m-d", strtotime($route->SetDate)).'"'; ?> />
            </div>
            <div data-role="fieldcontain">
              <label for="pic">Picture:</label>
              <input name="pic" id="pic" type="file" accept="image/*" capture="camera">
            </div>
            <div data-role="fieldcontain">
              <label for="Description">Description:</label>
              <textarea id="Description" maxlength="600" name="Description" placeholder="Describe the route (max 600 chars)..." ><? echo $route->Description; ?></textarea>
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
          <form action="./confirmAction.php" method="get" data-ajax="false" data-rel="dialog">
            <input type="hidden" name="Action" value="./deleteRoute.php">
            <input type="hidden" name="Info" value="Are you sure you want to delete this route?">
            <input type="hidden" name="Callback" value=<? echo "'./feed.php'"; ?> >
            <input type="hidden" name="RouteId" value=<? echo "'$route->Id'"; ?>>
            <input type="submit" value="Delete" data-theme="e" data-rel="dialog" data-icon="delete"/>
          </form>
        <? } // if($route) ?>
      </div>
    </div>
  </body>
</html>