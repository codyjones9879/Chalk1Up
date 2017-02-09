<?php
/**
 * Backend code for creating a new Climber. Emails them
 * a random password.
 *
 * @author     Ross Nordstrom <ross.nordstrom@chalk1up.net>
 * @copyright  2011-2013 Chalk1Up <contact@chalk1up.net>
 */
require_once('../database/TrainDatabase.php');
require_once('../database/Climber.php');
require_once('../database/Setter.php');
require_once('../database/Picture.php');

$db = new TrainDatabase();

$url = "./login.php?Info=".urlencode("Unable to Join...");

// First they must login as a climber
$climber = new Climber();
if($climber->fromExisting('',$_POST['username'],'') || $climber->fromExisting('','',$_POST['Email']) ) {
  $pwd = sha1($_POST['pwd']);

  // Climber exists, now try to login
  if($climber->login($pwd)) {
    // They authenticated as a Climber. Now we can setup their Setter account
    
    // Confirm it's a valid gym
    $gym = new Gym();
    if($gym->fromExisting($_POST['GymId'])) {
      // Confirm there isn't already a Setter at the given gym with their Name
      $setter = new Setter();
      if(!$setter->fromExisting('',$_POST['Name'],$_POST['GymId'])) {
        $setter->ClimberId = $climber->Id;
        $setter->Name = $_POST['Name'];
        $setter->GymId = $_POST['GymId'];

        $setter->PicId = 1;  // Anon User
        // If they uploaded a Picture, check it and resize for a Climber Picture
        if ((($_FILES["pic"]["type"] == "image/gif")
              || ($_FILES["pic"]["type"] == "image/png")
              || ($_FILES["pic"]["type"] == "image/jpg")
              || ($_FILES["pic"]["type"] == "image/jpeg")
              || ($_FILES["pic"]["type"] == "image/pjpeg"))) {
          if ($_FILES["pic"]["error"] == 0) {
            $picture = new Picture();
            $ext=strtolower(pathinfo($_FILES["pic"]["name"], PATHINFO_EXTENSION));
            if(move_uploaded_file($_FILES["pic"]["tmp_name"], $_FILES["pic"]["tmp_name"].".$ext") ) {
              $setter->PicId = $picture->newSetterPicture($_FILES["pic"]["tmp_name"].".$ext", "$setter->Name");
            }
          }
        }
        $setter->create();

        // Notify them of their temporary password and their login name via email
        $to=$climber->Email;
        $from="contact@chalk1up.net";
        $subject = "Welcome New Setter!";
        $msg = "Welcome to Chalk1Up's setting portal! If you have any questions, comments, or concerns please don't hesitate to contact us!
                Your login information is below. You can change your picture
                and bio on your profile at http://set.chalk1up.net?SetterId=$setter->Id
                Setter Name: $setter->Name
                Gym: $gym->Name
                Email: $climber->Email
                (Climber Name: $climber->Name)
                
                Regards,
                The Chalk1Up Team
                http://climb.chalk1up.net";
        $db->sendEmail($to,$from,$subject,$msg);

        $to="rdn11989@gmail.com";
        $from="contact@chalk1up.net";
        $subject = "[Chalk1Up] New Setter: $name";
        $msg = "New Setter:
                Setter Name: $setter->Name
                Gym: $gym->Name
                Email: $climber->Email
                (Climber Name: $climber->Name)";
        $db->sendEmail($to,$from,$subject,$msg);

        $url = "./login.php?Info=".urlencode("Joined, you can login now!");
      } else { // if setter doesnt exist
        $url = "./login.php?Info=".urlencode("Error: Setter name in use...");
      }
    } else { // if valid gym
      $url = "./login.php?Info=".urlencode("Error: Bad gym...");
    }
  } else { // if climber authenticated
    $url = "./login.php?Info=".urlencode("Error: Invalid password...");
  }
} else { // if climber exists
  $url = "./login.php?Info=".urlencode("Error: Invalid climber name or email...");
}

header("Location: $url");
ob_end_flush();
exit();

function isValidInetAddress($data, $strict = false) 
{ 
  $regex = $strict? 
      '/^([.0-9a-z_-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,4})$/i' : 
       '/^([*+!.&#$¦\'\\%\/0-9a-z^_`{}=?~:-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,4})$/i' 

  ; 
  if (preg_match($regex, trim($data), $matches)) { 
    return array($matches[1], $matches[2]); 
  } else { 
    return false; 
  } 
}

?>