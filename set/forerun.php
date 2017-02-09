<?php
/**
 * Lets user input Forerun info about a route after
 * forerunning it, such as # of attempts, 
 * rating, picture, and a comment
 *
 * @author     Ross Nordstrom <ross.nordstrom@chalk1up.net>
 * @copyright  2011-2013 Chalk1Up <contact@chalk1up.net>
 */
$_GET['TargetURL'] = "./feed.php";
require_once("./authenticate.php");
require_once('../database/TrainDatabase.php');
require_once('../database/Climber.php');
require_once('../database/Session.php');
require_once('../database/Route.php');
require_once('../database/Forerun.php');
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
        <a href=<? echo "'./feed.php'"; ?> data-role="button" data-icon="arrow-l" data-transition="slide" data-direction="reverse">Feed</a>
        <? if($route->Id) { ?>
          <h1><? echo "$route->Grade $route->Color @$area->Name"; ?></h1>
        <? } else { ?>
          <h1>Error: Invalid Route</h1>
        <? } ?>
      </div>
      <div data-role="content">
        <? if($route->Id) { ?>
          <h2>New Forerun?</h2>
          <form action="./insertForerun.php" method="post" data-ajax="false" enctype="multipart/form-data">
            <input type="hidden" name="RouteId" value=<? echo "'$route->Id'"; ?>/>
            <input type="hidden" name="Callback" value=<? echo "'./feed.php'"; ?> />
            <div data-role="fieldcontain">
              <label style="float:left" for="Rating">Rating:</label>
              <p class="refreshInfo">Refresh for rating! <a data-role="button" href="javascript:document.location.reload();">Refresh</a></p>
              <input required type="hidden" class="rating_star" name="Rating" id="Rating">
            </div>
            <div data-role="fieldcontain">
              <label for="SuggestedGrade">Suggested Grade:</label>
              <select name="SuggestedGrade" id="SuggestedGrade">
                <?
                  if($db->isValidGrade("Boulder", $route->Grade)) {
                    $grades = $db->getBoulderGrades();
                  } else if($db->isValidGrade("Rope", $route->Grade)) {
                    $grades = $db->getRopeGrades();
                  }
                  foreach ($grades as $g) { ?>
                    <option value=<? echo "'$g'"; if(strcmp($g,$route->Grade)==0) echo " selected"; ?>><? echo $g; ?></option>
                  <? } ?>
              </select>
            </div>
            <div data-role="fieldcontain">
              <label for="Comment">Comment:</label>
              <textarea id="Comment" maxlength="200" name="Comment" 
                placeholder="Comments about the route/moves/holds (e.g. 'Great flow!' or '2nd move was contrived, so I 
                              rotated the pinch 30 degrees')"></textarea>
            </div>
            <div data-role="fieldcontain">
              <label for="pic">Picture:</label>
              <input name="pic" id="pic" type="file" accept="image/*" capture="camera">
            </div>
            <div class="ui-grid-a">
              <div class="ui-block-a">
                <input type="submit" value="Submit" data-theme="b" data-rel="back" />
              </div>
              <div class="ui-block-b">
                <a href="#" data-role="button" data-rel="back">Cancel</a>
              </div>
            </div>
          </form>
          <image style="width:100%" src=<? echo "'$routePic->Pic'"; ?> title=<? echo "'$routePic->Caption'"; ?>>
          <div class="center-wrapper">
            <h3><? echo "$routePic->Caption"; ?></h3>
          </div>

          <div data-role="fieldcontain">
            <!-- <h2>Start tag:</h2> -->
            <ul data-role="listview">
              <li data-theme="b">
                <a href="#">
                  <h3>Route Start Tag</h3>
                </a>
                <ul>
                  <? echo $route->getStartTagForm(); ?>
                </ul>
              </li>
            </ul>
          </div>

          <?
          // List all the foreruns of this route (by this setter or all setters?)
          $foreruns = $route->getForeruns('', $asc = false);  // Get foreruns on this route by everyone
          if(count($foreruns) > 0) {
          ?>
            <h2>Foreruns on this Route:</h2>
            <ul data-role="listview">
              <?
              foreach ($foreruns as $forerun) {
                $forerunPic = $forerun->getPicture();
                $forerunner = $forerun->getSetter();
                $forerunnerPic = $forerunner->getPicture();
                $forerunDate = date("n/j", strtotime($forerun->Date));
                $rating = $forerun->Rating;
                ?>
                <li <? if($forerun->SetterId == $setter->Id) { echo "data-theme='c'"; } ?> >
                  <a href="#">
                    <h2><? echo "$forerunDate: Suggests $forerun->SuggestedGrade"; ?></h2>
                    <p class="refreshInfo">Refresh for ratings!</p>
                    <input disabled="disabled" type="hidden" class=<? echo "'rating_star_$rating'";?> name="Rating" id="Rating" />
                    <image src=<? echo "'$forerunnerPic->Thumb'"; ?> title=<? echo "'$forerunnerPic->Caption'"; ?> />
                  </a>
                  <ul>
                    <h1><? echo $forerunner->Name; ?> </h1>
                    <h2><? echo "$forerunDate: Suggests $forerun->SuggestedGrade"; ?></h2>
                  <p class="refreshInfo">Refresh for ratings!</p>
                  <input disabled="disabled" type="hidden" class=<? echo "'rating_star_$rating'";?> name="Rating" id="Rating" />
                    <? echo $forerun->Comment ? $forerun->Comment : "[No comments]"; ?>
                    <? if ($forerunPic) { ?>
                      <image style="width:100%" src=<? echo "'$forerunPic->Pic'"; ?> title=<? echo "'$forerunPic->Caption'"; ?>>
                    <? } ?>
                  </ul>
                </li>
              <? } // foreach(sends as send) ?>
            </ul>
          <? } // if (# foreruns > 0) ?>
          <?
          // List all the sends of this route (by this climber or all climbers?)
          $sends = $route->getSends('','', $asc = false);  // Get sends on this route by everyone
          // $sends = $route->getSends('', $climber->Id);  // Get sends by only this Climber
          if(count($sends) > 0) {
          ?>
            <h2>Climber Activity:</h2>
            <ul data-role="listview">
              <?
              foreach ($sends as $send) {
                $sendPic = $send->getPicture();
                $sender = $send->getClimber();
                $senderPic = $sender->getPicture();
                $sendDate = date("n/j", strtotime($send->getDate()));
                $tries = $send->Attempts==0 ? "Worked" : ($send->Attempts==1 ? "1 try" : "$send->Attempts tries");
                $theme = $send->Attempts==0 ? "data-theme='e'" : ($send->FirstTime ? "data-theme='c'" : "");
                $suggests = $send->SuggestedGrade==$route->Grade ? '' : ($send->SuggestedGrade ? "Suggests $send->SuggestedGrade" : '');
                $rating = $send->Rating;
                ?>
                <li <? echo $theme; ?> >
                  <a href=<? echo "'./send.php?SendId=$send->Id'";?>>
                    <h2><? echo "$sendDate: $tries $suggests"; ?></h2>
                    <p class="refreshInfo">Refresh for ratings!</p>
                    <input disabled="disabled" type="hidden" class=<? echo "'rating_star_$rating'";?> name="Rating" id="Rating" />
                    <br/><p><? echo $send->Description; ?></p>
                    <image src=<? echo "'$senderPic->Thumb'"; ?> title=<? echo "'$sender->Name'"; ?>>
                  </a>
                </li>
              <? } // foreach(sends as send) ?>
            </ul>
          <? } // if(# sends > 0) ?>
        <? } // if($route) ?>
      </div>
    </div>
  </body>
</html>