<!DOCTYPE HTML>
<html>
  <head>
    <title>Apparel: Ape Index - Chalk 1 Up</title>
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
          <h1>Ape Index</h1>
          <p>DaVinci may have been ahead of his time, but he got one thing wrong
            with his Vitruvian Man: the perfect person can't be placed in a square...
          </p>
          <img class="shirt-thumb" src="../images/design-ape_index-front.jpg"
            alt="Ape Index Front Design" title="Ape Index Front Design"/>
          <img class="shirt-thumb" src="../images/design-ape_index-back.jpg"
            alt="Ape Index Back Design" title="Ape Index Back Design"/>
        </div>
        <div id="mainImage" style="float:left; width:300px; margin-right: 40px">
          <h2>Select a Type, then a Color</h2>
          <img class="display" src="../images/apeindex_front.jpg"/>
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
                  '../images/thumb_canvas-blue.jpg, ../images/thumb_canvas-green.jpg, ../images/thumb_canvas-navy.jpg, ../images/thumb_canvas-brown.jpg, ../images/thumb_canvas-red.jpg',
                  '../images/canvas3001h-blue.jpg, ../images/canvas3001h-green-ape.jpg, ../images/canvas3001h-navy.jpg, ../images/canvas3001h-brown.jpg, ../images/canvas3001-canvasred.jpg',
                  'Heather Blue, Heather Green, Heather Navy, Heather Brown, Canvas Red',
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
                  '../images/thumb_bdry4120-gold.jpg, ../images/thumb_bdry4120-kelly.jpg',
                  '../images/bdry4120-gold.jpg, ../images/bdry4120-kelly.jpg',
                  'Gold, Kelly Green',
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
                    '../images/thumb_bdry4130-royal.jpg',
                    '../images/bdry4130-royal.jpg',
                    'Royal Blue',
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
                    '../images/thumb_anvil-black.jpg',
                    '../images/anvil-black.jpg',
                    'Black',
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
