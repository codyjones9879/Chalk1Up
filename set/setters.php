<?php
/**
 * List of the Climbers on the app (view either active or all)
 * and some brief stats about them
 *
 * @author     Ross Nordstrom <ross.nordstrom@chalk1up.net>
 * @copyright  2011-2013 Chalk1Up <contact@chalk1up.net>
 */
$_GET['TargetURL'] = "./setters.php";
require_once("./authenticate.php");
require_once('../database/TrainDatabase.php');
require_once('../database/Setter.php');
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
$goBackTo=date('Y-m-d', strtotime("-90 days"));

// Get the gym they set it
$gym = new Gym();
$gym = $gym->fromExisting($setter->GymId);

$showAll = (strcmp($_GET['ShowAll'], "True")==0) ? true : false;

$setters = $gym->getSetters();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Stats - Chalk1Up Mobile Trainer</title>
    <? include 'head1.html'; ?>
    <? include 'head2.html'; ?>
  </head>
  <body>
    <div data-role="page" id="home" data-theme="c">
      <? include 'navbar.php'; ?>
      <div data-role="content">
        <h2>Setter Stats:</h2>
        <? $callback = htmlspecialchars("./setters.php"); ?>
        <p class="refreshInfo">Refresh for ratings! <a data-role="button" href="javascript:document.location.reload();">Refresh</a></p>
	      <ul data-role="listview">
	        <?
	        foreach ($setters as $s) {
	        	$setterPic = $s->getPicture();
            $rating = round($s->getRating($current = true),2);
            $numRoutes = $s->getNumRoutes($current = true);
            $numSendsAndAttempts = $s->getSendsAndAttemptsPerRoute($current = true);
            $sendsPerRoute = $numSendsAndAttempts[0];
            $attemptsPerSend = ($sendsPerRoute>0) ? ($numSendsAndAttempts[1] / $sendsPerRoute) : "N/A";
            $numSends = ($sendsPerRoute>0) ? ($sendsPerRoute * $numRoutes) : "N/A";
		        ?>
		        <li id=<? echo "'Setter_$s->Id'"; ?> <? if($setter->Id == $s->Id) { echo "data-theme='c'";} ?> >
		          <a href=<? echo "'#'"; /*"'./stats.php?SetterId=$s->Id'";*/?> data-transition="slide">
		          	<h2><? echo $s->Name; ?></h2>
                <p><? echo "$sendsPerRoute Sends/Route"; ?></p>
                <p><? echo "$attemptsPerSend Attempts/Send"; ?></p>
                <input disabled="disabled" type="hidden" class=<? echo "'rating_star_$rating'";?> name="Rating" id="Rating">
                <span class="ui-li-count" title="Current #Routes"><? echo "$numRoutes"; ?></span>
		            <image style="float:left" src=<? echo "'$setterPic->Thumb'"; ?> title=<? echo "'$setterPic->Caption'"; ?>>
		          </a>
		        </li>
		      <? } ?>
	      </ul>
      </div>
      <? include 'footer.html'; ?>
    </div>
  </body>
</html>