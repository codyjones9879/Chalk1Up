<link rel="stylesheet" href="/style.css">
<?php
echo '<html><body style="color:black">';

$orders_filename = 'orders.txt';
$orders = file($orders_filename);
$order_id = count($orders) + 1;
$ok = 1;

/*
  print_r($orders);
  echo "<br/><br/><br/>";
  print_r($_FILES);
  echo "<br/><br/><br/>";
  /* */

$today = date("m/d/y - H:i:s", time());
$upload_folder = 'uploads/' . $order_id . '_';
$max_file_size = 20; // MB
$allowedExtensions = array("pdf", "jpg", "jpeg", "bmp", "gif", "png");

if (empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email'])
        || empty($_POST['price']) || empty($_POST['designdescr'])) {
  echo '<div class="container" style="background-color:red"><p>Please fill in all fields</p>' .
  '<input type="button" onclick="javascript:history.go(-1);" value="Return to Order Form"/>';
  echo '</div></body></html>';
  exit;
}

if (empty($_POST['color1']) || empty($_POST['color2']) || empty($_POST['color3'])) {
  echo '<div class="container" style="background-color:red"><p>Please make a selection for all three colors</p>' .
  '<input type="button" onclick="javascript:history.go(-1);" value="Return to Order Form"/>';
  echo '</div></body></html>';
  exit;
}


$name = $_POST['firstname'] . " " . $_POST['lastname'];
$visitor_email = $_POST['email'];
$price = $_POST['price'];
$descr = $_POST['designdescr'];
$color1 = $_POST['color1'];
$color2 = $_POST['color2'];
$color3 = $_POST['color3'];

// Setup the email
$submit_email = 'contact@chalk1up.net';
$email_subject = '[Order Request] ' . $name . ' - ' . $price;
$email_body = "Customer Name: $name\n" .
        "Order Received: $today \n" .
        "Email Address: $visitor_email\n" .
        "Bag Type: $price\n" .
        "Bag Colors: (Main) $color1, (Second) $color2, (Third) $color3\n" .
        "Design Description: " . "$descr\n";

// Check validity of the email address
$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
if (!preg_match($email_exp, $visitor_email)) {
  echo '<div class="container" style="background-color:red">';
  echo 'The email address you entered ($visitor_email) appears to be invalid.<br/>
        Please try again...';

  echo '</div></body></html>';
  exit;
}

// Upload files to the server
$file = $_FILES['imageupload'];
$numfiles = empty($file['name'][0]) ? 0 : count($file['name']);
if ($numfiles > 4) {
  echo '<div class="container" style="background-color:red"><p>' .
  'Sorry, but you may only upload 4 images. Please return and select 4 or fewer files...' .
  '</p><input type="button" onclick="javascript:history.go(-1);" value="Return to Order Form"/>';
  echo '</div></body></html>';
  exit;
}
if ($numfiles > 0) {
  $email_body .= "Attached Files: ";
}
for ($i = 0; $i < $numfiles; $i++) {
  $target = $upload_folder . $i . '_' . date('ymd-His', time()) . '_';
  $target = $target . basename($file['name'][$i]);
  $ok = 1;

  // Check file size
  $uploaded_size = $file['size'][$i];
  if ($uploaded_size > 2.5 * 1024 * 1024) {
    echo '<div class="container" style="background-color:red"><p>' .
    'Sorry, but you cannot upload files larger than 2.5MB. ' .
    'Please select smaller files and try again...' .
    '</p></div>';
    $ok = 0;
  }

  // Check the file type
  if ($numfiles > 0) {
    if (!in_array(end(explode(".", strtolower($file['name'][$i]))), $allowedExtensions)) {
      echo '<div class="container" style="background-color:red"><p>' .
	      'Found ' . $numfiles . ' files. ' .
      'Invalid file type found. Accepted types are: ' .
      implode(", ", $allowedExtensions) .
      '</p></div></body></html>';
      exit;
    }
  }

  // Attempt to upload the file to the server
  if (move_uploaded_file($file['tmp_name'][$i], $target)) {
    echo '<div class="container"><p>' .
    'The file ' . basename($file['name'][$i]) .
    ' has been uploaded</p></div>';

    $email_body .= "\t" . $file['name'][$i] . "\n";
  } else {
    echo '<div class="container" style="background-color:red"><p>' .
    'Sorry, there was a problem uploading your file (' .
    basename($file['name'][$i]) . ')' .
    '</p></div>';
  }
}
if (!$ok) {
  echo '<div class="container" style="background-color:red"><p>' .
  '<input type="button" onclick="javascript:history.go(-1);" ' .
  'value="Return to Order Form"/>' .
  '</p></div></body></html>';
  exit;
}

$headers = "From: $submit_email \r\n";
$headers .= "Reply-To: $visitor_email \r\n";
$headers .= "Cc: $visitor_email \r\n";

// Store this order on the server:
$this_order = $order_id . ', ' . $name . ', ' . $visitor_email . ', ' . $color1 .
        ' - ' . $color2 . ' - ' . $color3 . ', Ordered ' . $today . "\r\n";
file_put_contents($orders_filename, $this_order, FILE_APPEND | LOCK_EX);

// Submit the email
if (mail($submit_email, $email_subject, $email_body, $headers)) {
  echo '<div class="container">';
  $file = file_get_contents("./products/order-results.php");
  echo $file;
} else {
  echo '<div class="container" style="background-color:red">';
  echo 'Ah! Something happened, and we weren\'t able to send the email...<br/>';
  echo 'Please email contact@chalk1up.net with the following text (copy and '
  . 'paste into email). **Be sure to attach the image(s) you selected!<br/><br/>';

  $email_body_html_format = str_replace("\n", "<br/>", $email_body);
  echo $email_body_html_format;

  echo '<p><input type="button" onclick="window.close(); window.opener.focus()" value="Exit and email manually..."/></p>';
}
echo '</div></body></html>';
?>
