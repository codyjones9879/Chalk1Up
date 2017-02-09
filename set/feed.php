<?php
/**
 * set/feed.php:  Shows a feed of routes in the gym. It is sortable
 *                by which needs to be Stripped or Forerun first.
 *                It can also be filtered by Boulder/Rope/All and
 *                by Mine/Other Setters/All
 *
 * @author        Ross Nordstrom <ross.nordstrom@chalk1up.net>
 * @copyright     2011-2013 Chalk1Up <contact@chalk1up.net>
 */
$_SESSION['TargetURL'] = "./feed.php";
require_once("./authenticate.php");
require_once("../database/TrainDatabase.php");
require_once("../database/Setter.php");
require_once("../database/Gym.php");

$db = new TrainDatabase();

// Set up this Setter
$setter = new Setter();
$setter = $setter->fromExisting($_SESSION['SetterId']);
$today = date("Y-m-d");

// Get the gym they set it
$gym = new Gym();
$gym = $gym->fromExisting($setter->GymId);

// Get all the routes in the gym sorted by Forerun needs
$routesForerun = $gym->getRoutesAndSortBy("Forerun", 10);

// Get all the routes in the gym sorted by Strip needs
$routesStrip = $gym->getRoutesAndSortBy("Strip", 10);

// Get an Id-to-Name conversion table of this Gym's Areas
// AreaId is key, Name is value
$areas = $gym->getAreasByType('');

// Get an Id-to-Name conversion table of this Gym's Setters
// SetterId is key, Name is value
$tempSetters = $gym->getSetters();
foreach ($tempSetters as $s) {
  $setters[$s->Id] = $s;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Route Feed</title>
    <? include 'head1.html'; ?>
    <script src="./feed.js"></script>
    <? include 'head2.html'; ?>
  </head>
  <body>
    <div data-role="page" id="home" data-theme="c">
      <? include 'navbar.php'; ?>
      <div data-role="content" align="center">
        <div class="center-wrapper">
          <div style="display:none" class="center-wrapper refreshToShow">
            <fieldset data-role="controlgroup" data-type="horizontal" >
              <input type="radio" name="sort_by" id="sort_forerun" value="forerun" checked="checked" />
              <label for="sort_forerun">Forerun</label>
              <input type="radio" name="sort_by" id="sort_strip" value="strip"  />
              <label for="sort_strip">Strip</label>
            </fieldset>
            <fieldset data-role="controlgroup" data-type="horizontal" >
              <input type="radio" name="climb_type" id="type_b" value="boulder" checked="checked" />
              <label for="type_b">Boulder</label>
              <input type="radio" name="climb_type" id="type_r" value="rope"  />
              <label for="type_r">Rope</label>
              <input type="radio" name="climb_type" id="type_both" value="both"  />
              <label for="type_both">Both</label>
            </fieldset>
            <fieldset data-role="controlgroup" data-type="horizontal" >
              <input type="radio" name="set_by" id="set_by_me" value="me" checked="checked" />
              <label for="set_by_me">Mine</label>
              <input checked type="radio" name="set_by" id="set_by_others" value="others"  />
              <label for="set_by_others">Others</label>
              <input type="radio" name="set_by" id="set_by_all" value="all"  />
              <label for="set_by_all">All</label>
            </fieldset>
          </div>
        </div>
          <p class="refreshInfo">Please refresh your browser! <a data-role="button" href="javascript:document.location.reload();">Refresh</a></p>
        <h1 class="sort_forerun">Forerun Routes</h1>
        <ul class="sort_forerun" data-role="listview">
          <?
          foreach ($routesForerun as $route) {
            if($db->isValidGrade("Boulder", $route->Grade)) {
              $class = "boulder ";
            } else if($db->isValidGrade("Rope", $route->Grade)) {
              $class = "rope ";
            } else {
              continue;
            }
            if($setter->Id == $route->SetterId) {
              $class .= "mine ";
            } else {
              $class .= "others ";
            }
            // Get the name of the area the route is in
            $area = $areas[$route->AreaId];

            if(array_key_exists($route->SetterId, $setters)) {
              $s = $setters[$route->SetterId];
              $setterPic = $s->getPicture();
            } else {
              $setterPic=null;
            }

            if(!$areas[$route->AreaId]) {
              $area = new Area();
              $area->fromExisting($route->AreaId, '','');
              $areas[$route->AreaId] = $area;
              $areaPic = $area->getPicture();
            } else {
              $area = $areas[$route->AreaId];
            }
            $routePic = $route->getPicture();
            $rating = round($route->getRating(),2);

            $set = date("n/j", strtotime($route->SetDate));
            $exp = date("n/j", strtotime($route->ExpDate));

            $foreruns = $route->getForeruns();
            $numForeruns = count($foreruns);
            $i++;

            $requireForeruns = 4;       // TODO: Make this gym-specific

            $sends = count($route->getSends('Send'));
            $entries = count($route->getSends(''));
            ?>
            <li class=<? echo "'$class'"; ?> <? if($numForeruns < $requireForeruns) { echo "data-theme='e'"; } else { if($route->SetterId==$setter->Id) {echo "data-theme='c'";} } ?> >
              <a href=<? echo "'./forerun.php?RouteId=$route->Id'";?> data-transition="slide">
                <h4><? echo "$route->Grade $route->Color"; ?></h4>
                <h4><? echo "$area->Name"; ?></h4>
                <p><? echo "Set: $set, Exp: $exp"; ?></p>
                <p class="refreshInfo">Refresh for ratings!</p>
                <input disabled="disabled" type="hidden" class=<? echo "'rating_star_$rating'";?> name="Rating" id="Rating">
                <span <? if(!$hasSent) echo "data-theme='d'"; ?> class="ui-li-count" title="#Foreruns, #Sends/#Entries"><? echo "$numForeruns, $sends/$entries"; ?></span>
                <? if($setterPic) { ?>
                  <image style="float:left" src=<? echo "'$setterPic->Thumb'"; ?> title=<? echo "'$setterPic->Caption'"; ?>>
                <? } ?>
              </a>
              <a data-icon="edit" href=<? echo "'./editRoute.php?RouteId=$route->Id'"; ?> ></a>
            </li>
          <? } ?>
        </ul>
        <h1 class="sort_strip">Strip Routes</h1>
        <ul class="sort_strip" data-role="listview">
          <?
          foreach ($routesStrip as $route) {
            if($db->isValidGrade("Boulder", $route->Grade)) {
              $class = "boulder ";
            } else if($db->isValidGrade("Rope", $route->Grade)) {
              $class = "rope ";
            } else {
              continue;
            }
            if($setter->Id == $route->SetterId) {
              $class .= "mine ";
            } else {
              $class .= "others ";
            }
            // Get the name of the area the route is in
            $area = $areas[$route->AreaId];
            
            if(array_key_exists($route->SetterId, $setters)) {
              $s = $setters[$route->SetterId];
              $setterPic = $s->getPicture();
            } else {
              $setterPic=null;
            }

            if(!$areas[$route->AreaId]) {
              $area = new Area();
              $area->fromExisting($route->AreaId, '','');
              $areas[$route->AreaId] = $area;
              $areaPic = $area->getPicture();
            } else {
              $area = $areas[$route->AreaId];
            }
            $routePic = $route->getPicture();
            $rating = round($route->getRating(),2);

            $set = date("n/j", strtotime($route->SetDate));
            $exp = date("n/j", strtotime($route->ExpDate));

            $sends = count($route->getSends('Send'));
            $entries = count($route->getSends(''));
            ?>
            <li class=<? echo "'$class'"; ?> <? if($today>$exp || $rating==1 || $rating==2) { echo "data-theme='e'"; } else { if($route->SetterId==$setter->Id) {echo "data-theme='c'";} } ?> >
              <a href=<? echo "'./strip.php?RouteId=$route->Id'";?> data-transition="slide">
                <h4><? echo "$route->Grade $route->Color"; ?></h4>
                <h4><? echo "$area->Name"; ?></h4>
                <p><? echo "Set: $set, Exp: $exp"; ?></p>
                <p class="refreshInfo">Refresh for ratings!</p>
                <input disabled="disabled" type="hidden" class=<? echo "'rating_star_$rating'";?> name="Rating" id="Rating">
                <span <? if(!$hasSent) echo "data-theme='d'"; ?> class="ui-li-count" title="#Sends/#Entries"><? echo "$sends/$entries"; ?></span>
                <? if($setterPic) { ?>
                  <image style="float:left" src=<? echo "'$setterPic->Thumb'"; ?> title=<? echo "'$setterPic->Caption'"; ?>>
                <? } ?>
              </a>
              <a data-icon="edit" href=<? echo "'./editRoute.php?RouteId=$route->Id'"; ?> ></a>
            </li>
          <? } ?>
        </ul>
     </div>
     <? include 'footer.html'; ?>
    </div>
    <script>
      $( document ).on( "pageinit", function() {
        $( ".photopopup" ).on({
          popupbeforeposition: function() {
            var maxHeight = $( window ).height() - 60 + "px";
            $( ".photopopup img" ).css( "max-height", maxHeight );
          }
        });
      });
      $(function(){
        $('#rope_grades').hide();
      });
      $(function() {
        // $('#rope_grades').hide();
        $('#type_tr').click(function(){
          $('#boulder_grades').hide();
          $('#rope_grades').show();
        });
      });
      $(function() {
        $('#type_b').click(function(){
          $('#boulder_grades').show();
          $('#rope_grades').hide();
        });
      });
    </script>
  </body>
</html>