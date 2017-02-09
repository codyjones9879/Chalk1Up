<!DOCTYPE HTML>
<html>
  <title>Chalk 1 Up - Contact</title>
  <link rel="stylesheet" href="http://chalk1up.net/style.css">
  <script type="text/javascript" src="http://chalk1up.net/main.js"></script>
</head>
<body>
<? include '../navbar.php'; ?>
  <div id="content">
    <article>
      <div>
        <?php
        $to = "contact@chalk1up.net";
        $email = $_REQUEST['email'];
        $name = $_REQUEST['name'];
        $message = $name . ' - ' . $email . "\n\n" . $_REQUEST['message'];
        $subject = "[Contact Us] " . $name;
        $headers = "From: $to";
        $sent = mail($to, $subject,
        $message, $headers);
        if($sent) {print "Your mail was sent successfully";}
        else {print "We encountered an error sending your message, please try again or
        <a href='mailto:contact@chalk1up.net'>email us directly</a>"; }
        ?>
        <br/><br/>
        <input style="font-size:large;" type="submit" value="Return" onclick="history.go(-1)"/>
      </div>
    </article>
  </div>
<? include '../footer.html'; ?>
</body>
</html>