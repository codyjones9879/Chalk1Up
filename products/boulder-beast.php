<!DOCTYPE HTML>
<html>
  <head>
    <title>Apparel: Boulder Beast - Chalk 1 Up</title>
    <meta name="description" content="Products available from Chalk 1 Up." />
    <meta name="keywords" content="Products,CHALK1UP,Chalk,1,Up,Custom,Design,Designs,Rock,Climb,Climbing,Boulder,Bucket,Bag,Pot,Apparel,Shirt,Shirts,Ross,Nordstrom,Cat,Cody,Mollie" />
    <meta name="author" content="Ross Nordstrom" />
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    
    <link rel="stylesheet" href="http://chalk1up.net/style.css">
    <script type="text/javascript" src="../main.js"></script>
  </head>
  <body>
<? include '../navbar.php'; ?>
    <div id="content">
      <div id="article" style="width:960px">
        <div>
          <h1>Boulder Beast</h1>
          <p>You know that feeling you get when your non-climbing friends are in
            total disbelief of what you can do? Own it.
          </p>
          <img class="shirt-thumb" src="../images/design-boulder_beast-front.jpg"
            alt="Boulder Beast Front Design" title="Boulder Beast Front Design"/>
          <img class="shirt-thumb" src="../images/design-boulder_beast-back.jpg"
            alt="Boulder Beast Back Design" title="Boulder Beast Back Design"/>
        </div>
        <div id="mainImage" style="float:left; width:300px; margin-right: 40px">
          <h2>Select a Type, then a Color</h2>
          <img class="display" src="../images/bouldering_all.jpg"/>
          <h2>Price: <a id="price"></a></h2>
          <h2>Sizes Available: <a id="sizes"></a></h2>
        </div>
        <div style="float:left">
          <h2>Shirt Types</h2>
          <table>
            <tr>
              <td>
                <a href="#">
                  <img class="shirt-thumb" onclick="setColorChoices(
                  '../images/thumb_canvas-tan.jpg, ../images/thumb_canvas-green.jpg, ../images/thumb_canvas-slate.jpg, ../images/thumb_canvas-light-blue.jpg, ../images/thumb_canvas-pebble-brown.jpg',
                  '../images/canvas3001h-tan.jpg, ../images/canvas3001h-green.jpg, ../images/canvas3001h-slate.jpg, ../images/canvas3001-lightblue.jpg, ../images/canvas3001-pebblebrown.jpg',
                  'Heather Tan, Heather Green, Heather Slate, Light Blue, Pebble Brown',
                  '$18',
                  'S, M, L, XL'
                  ); return false"
                  src="../images/thumb_canvas.jpg" alt="Canvas - Soft and athletic fit"
                  title="Canvas - Soft and athletic fit"/>
                </a>
              </td>
              <td>
                <a href="#">
                  <img class="shirt-thumb" onclick="setColorChoices(
                  '../images/thumb_bdry4120-silver.jpg, ../images/thumb_bdry4120-maroon.jpg',
                  '../images/bdry4120-silver.jpg, ../images/bdry4120-maroon.jpg',
                  'Silver, Maroon',
                  '$20',
                  'M, L'
                  ); return false"
                  src="../images/thumb_bdry.jpg" alt="Badger Dry Fit - Wicks away sweat"
                  title="Badger Dry Fit - Wicks away sweat"/>
                </a>
              </td>
            </tr>
            <tr>
              <td>
                <a href="#">
                  <img class="shirt-thumb" onclick="setColorChoices(
                    '../images/thumb_bdry4130-black.jpg',
                    '../images/bdry4130-black.jpg',
                    'Black',
                    '$20',
                    'M, L'
                  ); return false"
                  src="../images/thumb_bdry_sleeveless.jpg" alt="Badger Dry Fit (Sleeveless) - Wicks away sweat"
                  title="Badger Dry Fit (Sleeveless) - Wicks away sweat"/>
                </a>
              </td>
              <td>
                <a href="#">
                  <img class="shirt-thumb" onclick="setColorChoices(
                    '../images/thumb_anvil-ash.jpg',
                    '../images/anvil-ash.jpg',
                    'Ash',
                    '$15',
                    'M, L'
                  ); return false"
                  src="../images/thumb_anvil.jpg" alt="Anvil Heavyweight Tank" title="Anvil Heavyweight Tank"/>
                </a>
              </td>
            </tr>
          </table>
        </div>
        <div>
          <h2>Color Choices</h2>
          <div id="colorChoices">
            Select a shirt type on the left...
          </div>
        </div>
      </div>
    </div>
<? include '../footer.html'; ?>
  </body>
</html>
