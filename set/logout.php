<?
/**
 * Logs the user out of the site
 *
 * @author     Ross Nordstrom <ross.nordstrom@chalk1up.net>
 * @copyright  2011-2013 Chalk1Up <contact@chalk1up.net>
 */
  session_name("Chalk1UpLogin");
  session_start();
  session_destroy();  // destroy session data in storage
  session_unset();    // unset $_SESSION variable for the runtime
  header("Location: ./login.php");
?>