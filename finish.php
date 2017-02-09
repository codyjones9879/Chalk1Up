<?php
/**
 * Stops the current session and takes a Description and overall Rating
 *
 * @author     Ross Nordstrom <ross.nordstrom@chalk1up.net>
 * @copyright  2011-2012 Chalk1Up <contact@chalk1up.net>
 */
require_once("./authenticate.php");
require_once('../database/TrainDatabase.php');
require_once('../database/Climber.php');
require_once('../database/Session.php');
require_once('../database/Gym.php');
require_once('../database/Picture.php');

$db = new TrainDatabase();
$climber = new Climber();
if(!$climber->fromExisting($_SESSION['Id'],'','') ) {
  // Somehow this isn't a valid Climber, or $_SESSION['Id'] isn't set
  print_r("Invalid climber");
  exit();
}
$today=date('Y-m-d');

$session = new Session();
if($session->fromExisting($_SESSION['SessionId'],'','','')) {
	$gym = $session->getGym();
}

$time=new DateTime(null, new DateTimeZone($gym->Timezone));
$interval=$_SESSION['CLIMB_START']->diff($time);
$h = $interval->h;
$h = ($h=='') ? '0' : $h;
$i = str_pad($interval->i,2,'0',STR_PAD_LEFT);
$s = str_pad($interval->s,2,'0',STR_PAD_LEFT);
$session->Length = $h.":".$i.":".$s;

$session->update();
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
        <h1>Finished climbing?</h1>
      </div>
      <div data-role="content">
        <form method="post" action="./stop.php" data-ajax="false">
          <div data-role="fieldcontain">
            <label style="float:left" for="Rating">Rating:</label>
            <p class="refreshInfo">Refresh for rating! <a data-role="button" href="javascript:document.location.reload();">Refresh</a></p>
            <input type="hidden" class="rating_star" name="Rating" id="Rating">
          </div>
          <div data-role="fieldcontain">
            <label for="Description">Description:</label>
            <textarea id="Description" maxlength="600" name="Description" ><? echo str_replace("\\", "", $session->Description); ?></textarea>
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
    <script language="javascript" type="text/javascript">
      var javaCalled = false;
      $(document).on('pagecreate pageinit pageshow','div:jqmData(role="page"), div:jqmData(role="dialog")', function() {
        if(!javaCalled) {
          // $('#rating').rating('readOnly',true);
          $('.rating_star').webwidget_rating_star({
            rating_star_length: '5',
            rating_initial_value: '',
            rating_function_name: '',
            directory: 'http://chalk1up.net/rating_star/images/'
          });
          $('.rating_star_0').webwidget_rating_star({
            rating_star_length: '5',
            rating_initial_value: '',
            rating_function_name: '',
            directory: 'http://chalk1up.net/rating_star/images/'
          });
          $('.rating_star_1').webwidget_rating_star({
            rating_star_length: '5',
            rating_initial_value: '1',
            rating_function_name: '',
            isDisabled: true,
            directory: 'http://chalk1up.net/rating_star/images/'
          });
          $('.rating_star_2').webwidget_rating_star({
            rating_star_length: '5',
            rating_initial_value: '2',
            rating_function_name: '',
            directory: 'http://chalk1up.net/rating_star/images/'
          });
          $('.rating_star_3').webwidget_rating_star({
            rating_star_length: '5',
            rating_initial_value: '3',
            rating_function_name: '',
            directory: 'http://chalk1up.net/rating_star/images/'
          });
          $('.rating_star_4').webwidget_rating_star({
            rating_star_length: '5',
            rating_initial_value: '4',
            rating_function_name: '',
            directory: 'http://chalk1up.net/rating_star/images/'
          });
          $('.rating_star_5').webwidget_rating_star({
            rating_star_length: '5',
            rating_initial_value: '5',
            rating_function_name: '',
            directory: 'http://chalk1up.net/rating_star/images/'
          });
          $('.refreshInfo').hide();
          javaCalled=true;
        }
      });
    </script>
  </body>
</html>