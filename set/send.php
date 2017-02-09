<?php
/**
 * Lets user input Send info about a route after climbing it,
 * such as # of attempts, rating, picture, description
 *
 * @author     Ross Nordstrom <ross.nordstrom@chalk1up.net>
 * @copyright  2011-2013 Chalk1Up <contact@chalk1up.net>
 */
$_GET['TargetURL'] = "./send.php?SendId=".$_GET['SendId'];
require_once("./authenticate.php");
require_once('../database/TrainDatabase.php');
require_once('../database/Climber.php');
require_once('../database/Session.php');
require_once('../database/Gym.php');
require_once('../database/Picture.php');

$db = new TrainDatabase();
$today=date('Y-m-d');
$session = new Session();
$send = new Send();
if($send->fromExisting($_GET['SendId'])) {
  $session = $send->getSession();
  $route = $send->getRoute();
  $gym = $send->getGym();
  $pic = $send->getPicture();
  $sender = $send->getClimber();
  $senderPic = $sender->getPicture();
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
      <? include 'navbar.php'; ?>
      <div data-role="header" data-id="train-header" data-theme="c">
        <? if($send) { ?>
          <a href=<?echo "'./forerun.php?RouteId=$send->RouteId'";?> data-direction="reverse" data-role="button" data-icon="arrow-l" data-transition="slide">Forerun</a>
          <h1><? echo $sender->Name." - ".date("n/j",strtotime($session->Date)); ?></h1>
        <? } else { ?>
          <a data-rel="back" data-role="button" data-icon="arrow-l" data-transition="slide">Back</a>
          <h1>Invalid Send</h1>
        <? } ?>
      </div>
      <div data-role="content">
        <? if($send) { 
          // Make sure we have this Send's Route info
          if(!$routes[$send->RouteId]) {
            // We don't have this Route's info, so grab and store it
            $routes[$send->RouteId] = $send->getRoute();
          }
          $route = $routes[$send->RouteId];
          $area = $route->getArea();

          $time = date("G:i", strtotime($send->Time));
          $tries = $send->Attempts==0 ? "Worked" : ($send->Attempts==1 ? "1 try" : "$send->Attempts tries");
          ?>
            <? if($permission) { ?>
              <form action="./updateSend.php" method="post" data-ajax="false" enctype="multipart/form-data">
                <input type="hidden" name="SendId" value=<? echo "'$send->Id'"; ?>/>
                <? if(!$grade) { ?>
                  <input type="hidden" name="Callback" value=<? echo "./sessionInfo.php?SessionId=$session->Id"; ?> />
                <? } ?>
                <div data-role="fieldcontain">
                  <label style="float:left" for="Rating">Rating:</label>
                  <p class="refreshInfo">Refresh for rating!</p>
                  <input type="hidden" class="rating_star" name="Rating" id="Rating">
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
                        <option value=<? echo "'$g'"; if(strcmp($g,$route->SuggestedGrade)==0) echo " selected"; ?>><? echo $g; ?></option>
                      <? } ?>
                  </select>
                </div>
                <div data-role="fieldcontain">
                  <label for="Attempts">Attempts: (0: Worked)</label>
                  <input type="range" maxlength="20" name="Attempts" value=<? echo "'$send->Attempts'"; ?> id="Attempts" min="0" max="20" title="# of attempts. 0 means you worked but didn't send it" />
                </div>
                <div data-role="fieldcontain">
                  <label for="Description">Description:</label>
                  <textarea id="Description" maxlength="200" name="Description"><? echo $send->Description; ?></textarea>
                </div>
                  <div data-role="fieldcontain">
                    <label for="GymVisible">Share with Gym?</label>
                    <input type="checkbox" id="GymVisible" name="GymVisible" value=<? echo "'$send->GymVisible'"; ?> />
                  </div>
                <div data-role="fieldcontain">
                  <label for="pic">Picture (will delete old one below):</label>
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
              <a data-role="button" data-theme="e" data-rel="dialog" href=<? echo "'./confirmAction.php?Action=".urlencode("./deleteSend.php")."&SendId=$send->Id&Callback=".urlencode("./sessionInfo.php?SessionId=$session->Id")."&Info=".urlencode("Are you sure you want to delete this send?")."'"; ?> data-icon="delete">Delete</a>
              <?
            } else {
              // No edit permissions
              ?>
              <ul data-role="listview" data-theme="b">
                <li>
                  <image style="width:100%" src=<? echo "'$senderPic->Pic'"; ?> >
                  <h2><? echo "$route->Grade $route->Color - $tries"; ?></h2>
                  <h3><? echo "$time @$area->Name"; ?></h3>
                  <? if($send->SuggestedGrade && $send->SuggestedGrade!=$route->Grade) { ?>
                    <h3><? echo "Suggests: $send->SuggestedGrade"; ?></h3>
                  <? } ?>
                  <div data-role="fieldcontain">
                    <p class="refreshInfo">Refresh for ratings! <a data-role="button" href="javascript:document.location.reload();">Refresh</a></p>
                    <input disabled="disabled" type="hidden" class=<? echo "'rating_star_$send->Rating'";?> name="Rating" id="Rating">
                  </div>
                  <p><? echo ($send->Description ? $send->Description : "[No Description]"); ?><p>
                </li>
              </ul>
              <?
            } // no edit permissions
            if($send->PicId) { ?>
              <div class="center-wrapper">
                <image style="width:100%" src=<? echo "'$pic->Pic'"; ?> title=<? echo "'$pic->Caption'"; ?>>
              </div>
            <? } ?>

            <?
            // List all the sends of this route (by this climber or all climbers?)
            $otherSends = $route->getSends('','', $asc = false);  // Get sends on this route by everyone
            // $sends = $route->getSends('', $climber->Id);  // Get sends by only this Climber
            if(count($otherSends) > 1) {
              ?>
              <h2>Activity on this Route:</h2>
              <ul data-role="listview" data-theme="c">
                <?
                foreach ($otherSends as $otherSend) {
                  if($otherSend->Id == $send->Id) {
                    continue; // don't show the send they're looking at as "other activity"
                  }
                  $sender = $otherSend->getClimber();
                  $senderPic = $sender->getPicture();
                  $sendDate = date("n/j", strtotime($otherSend->getDate()));
                  $tries = $otherSend->Attempts==0 ? "Worked" : ($otherSend->Attempts==1 ? "1 try" : "$otherSend->Attempts tries");
                  $theme = $otherSend->Attempts==0 ? "data-theme='e'" : ($otherSend->FirstTime ? "data-theme='c'" : "");
                  $suggests = $otherSend->SuggestedGrade==$route->Grade ? '' : ($otherSend->SuggestedGrade ? "Suggests $otherSend->SuggestedGrade" : '');
                  $rating = $otherSend->Rating;
                  ?>
                  <li <? echo $theme;?> >
                    <a href=<?echo "'./send.php?SendId=$otherSend->Id'";?>>
                      <h2><? echo "$sendDate: $tries $suggests"; ?></h2>
                      <p class="refreshInfo">Refresh for ratings!</p>
                      <input disabled="disabled" type="hidden" class=<? echo "'rating_star_$rating'";?> name="Rating" id="Rating" />
                      <br/><p><? echo $otherSend->Description; ?></p>
                      <image src=<? echo "'$senderPic->Thumb'"; ?> title=<? echo "'$sender->Name'"; ?>>
                    </a>
                  </li>
                <? } // foreach(otherSends as otherSend) ?>
              </ul>
            <? } // if(# otherSends > 0) ?>

        <? } else { // if valid send ?>
          <h1>Invalid Send. Please go back.</h1>
        <? } ?>
      </div>
    </div>
  </body>
</html>