<!DOCTYPE HTML>
<html>
  <title>Contact - Chalk 1 Up</title>
  <meta name="description" content="Contacting Chalk 1 Up." />
  <meta name="keywords" content="Contact,CHALK1UP,Chalk,1,Up,Custom,Design,Designs,Rock,Climb,Climbing,Boulder,Bucket,Bag,Pot,Apparel,Shirt,Shirts,Ross,Nordstrom,Cat,Cody,Mollie" />
  <meta name="author" content="Ross Nordstrom" />
  <meta http-equiv="content-type" content="text/html;charset=UTF-8" />

  <link rel="stylesheet" href="http://chalk1up.net/style.css">
  <script type="text/javascript" src="http://chalk1up.net/main.js"></script>
</head>
  <body>
<? include '../navbar.php'; ?>
    <div id="content">
      <div id="article">
        <div>
          <h1>Contact Us</h1>
          <p>We love to hear feedback, both good and bad! You can contact us 
            either by email or in person. All four of us climb at Boulders
            (Madison) and, very infrequently, Adventure Rock (Pewaukee).
            We are both friendly and love meeting new people, so please
            don't hesitate to approach us!
          </p>
        </div>
        <div>
          <h2>Send us a Message</h2>
          <form method="post" action="./results.php">
            Name (optional): <input type="text" name="name" placeholder="John Smith"/>
            Email (optional): <input type="text" name="email" 
                                     placeholder="john.smith@example.com"/><br/>
            Message: <br/><textarea rows="6" cols="64" name="message" required></textarea>
            <br/>
            <input style="font-size:large;" type="submit" name="submit" value="Submit"/>
          </form>
        </div>
      </div>
      <div id="aside">
        <div>
          <h1>Chalk 1 Up</h1>
          <h2>Custom Designs</h2>
          <h3>
            <a href="mailto:contact@chalk1up.net">contact@chalk1up.net</a></h3>
        </div>
      </div>
    </div>
<? include '../footer.html'; ?>
  </body>
</html>