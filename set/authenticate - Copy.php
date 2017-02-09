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

if($_GET['action'] == "login") {
  $name = $_POST['user'];
  $email = $_POST['email'];
  $pwd = sha1($_POST['pwd']);
  $remember = (bool) $_POST['remember'];

  $climber = new Climber();
  if(!$climber->fromExisting('', $name, $email)) {
    // Invalid Climber
    header("Location: ./login.php?login=failed&cause=".urlencode('Invalid User'));
    exit;
  }

  // Climber exists, now try to login
  if(!$climber->login($pwd)) {
    // Invalid password
    header("Location: ./login.php?login=failed&cause=".urlencode('Invalid Password'));
    exit();
  }

  // LOGGING IN! User is valid
  $_SESSION['Id']=$climber->Id;
  $_SESSION['Name']=$climber->Name;
  $_SESSION['LAST_ACTIVITY']=time();
  $_SESSION['REMEMBER_ME']=$remember;

  if($remember) {
    $cookie = rand();
    $climber->Cookie = sha1($cookie);
    $climber->update();

    // Setup a Cookie to prevent future logins
    $cookieExp = time() + 7*24*60*60; // 1 week
    setcookie("Chalk1UpId", $climber->Id, $cookieExp);
    setcookie("Chalk1UpName", $climber->Name, $cookieExp);
    setcookie("Chalk1Up", $cookie, $cookieExp);
  }

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

// Do they have cookies set?
if(isset($_COOKIE['Chalk1UpId']) && isset($_COOKIE['Chalk1UpName']) && isset($_COOKIE['Chalk1Up'])) {
  $climber = new Climber();
  if($climber->fromExisting('',$_COOKIE['Chalk1UpName']) 
     && $climber->Id==$_COOKIE['Chalk1UpId']
     && $climber->Cookie==sha1($_COOKIE['Chalk1Up'])) {
    // Their cookies are valid, let them in!
    $_SESSION['Id']=$climber->Id;
    $_SESSION['Name']=$climber->Name;
    $_SESSION['LAST_ACTIVITY']=time();
    $_SESSION['REMEMBER_ME']=true;
    $valid = true;
  }
}

if(!$valid) {
  if (isset($_SESSION['Id']) && isset($_SESSION['Name']) && isset($_SESSION['LAST_ACTIVITY'])) {
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
}
?>