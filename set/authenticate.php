<?php
/**
 * Controls access to the site based based on login status
 *
 * @author     Ross Nordstrom <ross.nordstrom@chalk1up.net>
 * @copyright  2011-2013 Chalk1Up <contact@chalk1up.net>
 */
// if(!session_name()) {
  session_name("Chalk1UpLogin");
  session_start();
// }
$target = $_SESSION['TargetURL'] = $_GET['TargetURL'] ? $_GET['TargetURL'] : "./index.php";

require_once('../database/Climber.php');
require_once('../database/Setter.php');

$blacklist = array(new Climber(), new Climber(), new Climber(), new Climber(), new Climber(), new Climber());
$blacklist[0]->fromExisting(29,'','');
$blacklist[1]->fromExisting('','benoram','');
$blacklist[2]->fromExisting('','','ben.oram@gmail.com');

if($_GET['action'] == "login") {
  $pwd = sha1($_POST['pwd']);
  $remember = (bool) $_POST['remember'];
  $climber = new Climber();

  $gym = new Gym();
  if($_POST['GymId']) {
    $gym->fromExisting($_POST['GymId']);
  } else if($_POST['Lat'] && $_POST['Long']) {
    $nearGyms = $climber->getGymsByProximity($_POST['Lat'], $_POST['Long'], 10);
    if(count($nearGyms)>0) {
      $gym = $nearGyms[0];
    }
  }
  if(!$gym->Id) {
    header("Location: ./login.php?login=failed&cause=".urlencode('No gym selected...'));
    exit;
  }

  $setter = new Setter();
  if(!$setter->fromExisting('',$_POST['username'],$gym->Id)) {
    // Try using the username as a Climber email
    if (!($climber->fromExisting('', '', $_POST['username'])
            || $climber->fromExisting('',$_POST['username'])
        )
        || !$setter->fromExisting('','',$gym->Id,$_POST['username'])
      ) {
      // Setter didn't enter their Climber email
      header("Location: ./login.php?login=failed&cause=".urlencode('Invalid Setter'));
      exit;
    }
  } else {
    if(!$climber->fromExisting($setter->ClimberId)) {
      header("Location: ./login.php?login=failed&cause=".urlencode('Invalid Setter'));
      exit;
    }
  }

  // Climber exists, now try to login
  if(!$climber->login($pwd)) {
    // Invalid password
    header("Location: ./login.php?login=failed&cause=".urlencode('Invalid Password'));
    exit();
  }

  if($climber->matchesClimberInList($blacklist)) {
    // This climber is blacklisted, deny them access
    header("Location: ./login.php?login=failed&cause=".urlencode('Login Error'));
    exit();
  }

  // User is valid
  $_SESSION['Id']=$climber->Id;
  $_SESSION['Name']=$climber->Name;
  $_SESSION['SetterId']=$setter->Id;
  $_SESSION['SetterName']=$setter->Name;
  $_SESSION['LAST_ACTIVITY']=time();
  $_SESSION['REMEMBER_ME']=$remember;

  // TODO: During development, limit access
  if(strpos(getcwd(), 'dev') || strpos(getcwd(), 'ross') || strpos(getcwd(), 'cody')) {
    require_once('./devlog.php');
  }
  $url = "./index.php";
  if($_SESSION['TargetURL']) {
    $url = $_SESSION['TargetURL'];
  }
  header("Location: $url");
  exit();
}

if (isset($_SESSION['Id']) && isset($_SESSION['SetterId']) && isset($_SESSION['LAST_ACTIVITY'])) {
  if (!isset($_SESSION['REMEMBER_ME']) || $_SESSION['REMEMBER_ME']==false) {
    $_SESSION['REMEMBER_ME']=false; // Make sure it is set

    // Check if it's been more than 4 days since last activity
    if (time() - $_SESSION['LAST_ACTIVITY'] > 345600) {
      // session_destroy();  // destroy session data in storage
      // session_unset();    // unset $_SESSION variable for the runtime
      unset($_SESSION['Id']);
      header("Location: ./login.php?login=failed&cause=".urlencode('Login session expired')."&TargetURL=$target");
      exit();
    }
  }
  $_SESSION['LAST_ACTIVITY']=time();  // Reset the activity timer
  // TODO: During development, limit access
  if(strpos(getcwd(), 'dev') || strpos(getcwd(), 'ross') || strpos(getcwd(), 'cody')) {
    require_once('./devlog.php');
  }
} else {
  // session_destroy();
  // session_unset();
  header("Location: ./login.php?TargetURL=".$_SESSION['TargetURL']."&bs=Climber:$climber->Id $climber->Name");
  exit();
}
?>