<?php
/**
 * Login screen
 *
 * @author     Ross Nordstrom <ross.nordstrom@chalk1up.net>
 * @copyright  2011-2013 Chalk1Up <contact@chalk1up.net>
 */
$target = $_SESSION['TargetURL'] = $_GET['TargetURL'] ? $_GET['TargetURL'] : "./index.php";
require_once('../database/TrainDatabase.php');
require_once('../database/Gym.php');
$db = new TrainDatabase();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Login - Chalk1Up Mobile Trainer</title>
    <? include 'head1.html'; ?>
    <script src="./js/geolocation.js"></script>
    <? include 'head2.html'; ?>
  </head>
  <body>
    <div data-role="page" id="home" data-theme="c">
      <? include 'navbar.php'; ?>
      <div data-role="content">
        <div>
          <ul data-role="listview" data-theme="c">
            <li>
              <h3>Forgot Password?</h3>
              <ul>
                <h3>Password Recovery:</h3>
                <form method="post" action="./recover.php" data-ajax="false">
                  <input required type="text" id="username" name="username" placeholder="Email or Username" />
                  <div class="ui-grid-a">
                    <div class="ui-block-a">
                      <input type="submit" value="Recover" data-theme="b" data-rel="back" />
                    </div>
                    <div class="ui-block-b">
                      <a href="#" data-role="button" data-rel="back">Cancel</a>
                    </div>
                  </div>
                </form>
              </ul>
            </li>
            <li>
              <h3>First time? Join:</h3>
              <ul>
                <div data-role="fieldcontain">
                  <h3>First time on Chalk1Up?</h3>
                  <p>You must already have a Climber account</p>
                  <a data-theme="b" data-role="button" href="http://climb.chalk1up.net/login.php">Become a Climber</a>
                </div>
                <div>
                  <h3>Join as Setter:</h3>
                  <form method="post" data-ajax="false" action="./join.php" enctype="multipart/form-data">
                    <input required type="text" id="Name" name="Name" placeholder="Setter Name (Ex: RN, SlabMaster)" />
                    <input required type="text" id="username" name="username" placeholder="Email or Climbing Name" />
                    <input required type="password" id="pwd" name="pwd" placeholder="Password" />
                    <label for="GymId">Gym:</label>
                    <select required id="GymId" name="GymId">
                      <option disabled>Where do you set?</option>
                      <?
                        $gyms = $db->getGyms();
                        foreach ($gyms as $gym) {
                          echo '<option value="'.$gym->Id.'">'.$gym->Name.'</option>';
                        }
                      ?>
                    </select>
                    <div data-role="fieldcontain">
                      <label for="pic">Setter Picture:</label>
                      <input name="pic" id="pic" type="file" accept="image/*" capture="camera">                
                    </div>
                    <div class="ui-grid-a">
                      <div class="ui-block-a">
                        <input type="submit" value="Join" data-theme="b" data-rel="back" />
                      </div>
                      <div class="ui-block-b">
                        <a href="#" data-role="button" data-rel="back">Cancel</a>
                      </div>
                    </div>
                  </form>
                </div>
              </ul>
            </li>
          </ul>
        </div>
        <? if($_GET['Info']) { ?>
          <div class="ui-btn-right ui-bar-d" data-role="button" data-icon="info">
            <? echo $_GET['Info']; ?>
          </div>
        <? } ?>
        <? if($_GET['login'] == "failed") { ?>
          <a id="login_alert" href="#" onclick="$('#login_alert').hide();" class="ui-btn-right ui-bar-e" data-role="button" data-icon="delete" data-mini="true" title="dismiss">
            <strong>Login failed:</strong> <? echo urldecode($_GET['cause']); ?>
          </a>
        <? } ?>
        <h2>Login as Setter:</h2>
        <form name="login_form" method="post" action=<? echo "'./authenticate.php?action=login&TargetURL=$target'"; ?> data-ajax="false">
          <input type="hidden" id="Lat" name="Lat">
          <input type="hidden" id="Long" name="Long">
          <input required type="text" id="user" name="user" placeholder="Climb username or Email" />
          <!-- <select required id="GymId" name="GymId">
            <option disabled>Select a Gym:</option>
            <?
              $gyms = $db->getGyms();
              foreach ($gyms as $gym) {
                echo '<option value="'.$gym->Id.'">'.$gym->Name.'</option>';
              }
            ?>
          </select>
          <p class="refreshInfo">Refresh your browser for geolocation!<a data-role="button" href="javascript:document.location.reload();">Refresh</a></p> -->
          <input required type="password" id="pwd" name="pwd" placeholder="Password" />
          <label for="remember">Remember Me</label>
          <input type="checkbox" id="remember" name="remember" value="Remember Me" />
          <input type="submit" value="Sign In" data-theme="b">
        </form>
        <!-- <p class="geolocInfo"></p> -->
      </div>
      <? include 'footer.html'; ?>
    </div>
  </body>
</html>