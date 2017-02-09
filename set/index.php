<?php
/**
 * Main mobile page. Briefly explains the site's features.
 *
 * @author     Ross Nordstrom <ross.nordstrom@chalk1up.net>
 * @copyright  2011-2013 Chalk1Up <contact@chalk1up.net>
 */
$_GET['TargetURL'] = "./index.php";
require("./authenticate.php");
require_once('../database/Climber.php');
require_once('../database/Picture.php');

// Set up this Setter
$setter = new Setter();
if(!$setter = $setter->fromExisting($_SESSION['SetterId'])) {
  // Somehow this isn't a valid Climber, or $_SESSION['SetterId'] isn't set
  print_r("Invalid setter");
  exit();
}
$pic = $setter->getPicture();
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
      <div data-role="content">
        <h2>Mobile Setter</h2>
        <h3>Set:</h3>
        <p>
          This tool is meant to help you make better decisions on where and what to
          set, based on what is out there. You don't have to look at all the routes -
          we'll do all the thinking for you!
        </p>
        <h3>Feed:</h3>
        <p>
          You can also use our tool to help you forerun the routes that need it, and
          strip the routes that have been up too long.
        </p>
        <h3>Stats:</h3>
        <p>
          Click on Stats to see how you stack up compared to the other setters at
          your gym. You can also quickly see how you're doing compared to your
          historical stats. We aggregate route usage and climber feedback here to
          help you figure out what you've done well and what could be improved!
        </p>
        <h3>Home:</h3>
        <p>
          Click the house-shaped icon in the upper-right to return to this screen.
        </p>
        <? if($_GET['Info']) { ?>
          <div class="ui-btn-right ui-bar-c" data-theme="c" data-role="button" data-icon="info">
            <? echo $_GET['Info']; ?>
          </div>
        <? } ?>
        <h2>Profile:</h2>
        <ul data-role="listview">
          <li>
            <a href=<? echo "'./stats.php?SetterId=$setter->Id'";?> data-transition="slide">
              <h2><? echo $setter->Name; ?></h2>
              <image src=<?echo "'$pic->Thumb'";?> title=<?echo "'$pic->Caption'";?> >
            </a>
          </li>
        </ul>
        <div data-role="fieldcontain">
          <a href="./logout.php" data-role="button" data-icon="delete">Logout</a>
        </div>
      </div>
      <? include 'footer.html'; ?>
    </div>
  </body>
</html>