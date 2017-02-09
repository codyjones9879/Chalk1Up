<!DOCTYPE HTML>
<html style="background-color:whitesmoke">
  <head>
    <title>Request a Boulder Bucket - Chalk 1 Up</title>
    <link rel="stylesheet" href="../style.css">
    <script type="text/javascript" src="../main.js"></script>
    <script type="text/javascript" src="orderbag.js"></script>
  </head>
  <body onload="updateSampleBag(350); restoreColors()">
    <div class="container" style="width:800px; vertical-align: middle">
      <form action="../orderform-to-email.php" onsubmit="return validateColors()" method="post" enctype="multipart/form-data">
        <h2 class="center">Request a Boulder Bucket</h2>
        <h3>Note that we are not able to process orders right now because
        Cat (who makes the bags) is too busy to sew them while in nursing school.
        Once she has time, or we find an alternative method of making the bags,
        orders will be processed on a first-come-first-served basis, so placing
        a request will help get you a bag faster (eventually).</h3>
        <table class="orderform">
          <tr>
            <td style="width:200px;">
              <table>
                <tr>
                  <th class="right">First name:</th>
                  <td><input type="text" name="firstname" id = "firstname" required
                             placeholder="John"/></td>
                </tr>
                <tr>
                  <th class="right">Last name:</th>
                  <td><input type="text" name="lastname" required
                             placeholder="Smith"/></td>
                </tr>
                <tr>
                  <th class="right">Your Email:</th>
                  <td><input type="text" name="email" required
                             placeholder="john.smith@example.com"/></td>
                </tr>
                <tr>
                  <th class="right" rowspan="2">Bag Type:</th>
                  <td><input type="radio" name="price" value="$70 basic" required/>$70 - Basic Boulder Bucket</td>
                </tr>
                <tr>
                  <td><input type="radio" name="price" value="$80 custom" required/>$80 - Fully Custom Boulder Bucket</td>
                </tr>
                <tr>
                  <th class="right">Description of Design</th>
                  <td>
                    <textarea name="designdescr" rows="6" cols="25" required
                              placeholder="Describe what you want..."></textarea>
                  </td>
                </tr>
                <tr>
                  <th class="right">Upload up to 4 Images (Optional)</th>
                  <td>
                    <input name="imageupload[]" type="file" multiple="multiple"/>
                  </td>
                </tr>
              </table>
            </td>
            <td class="center">
              <h3>Select Your Bag's Colors:</h3>
              <table>
                <tr>
                  <th colspan="3" class="center">
                    <canvas id="sampleBag"></canvas>
                  </th>
                </tr>
                <tr>
                  <th class="center">Main Color:</th>
                  <th class="center">Second Color:</th>
                  <th class="center">Third Color:</th>
                </tr>
                <tr>
                  <td>
                    <table>
                      <tr>
                        <td>
                          <table class="swatch">
                            <tr>
                              <td class="white" onclick="setColor1('white', 'White')"> </td>
                              <td class="natural" onclick="setColor1('natural', 'Natural')"> </td>
                              <td class="grey" onclick="setColor1('grey', 'Grey')"> </td>
                              <td class="classicbrown" onclick="setColor1('classicbrown', 'Classic Brown')"> </td>
                              <td class="black" onclick="setColor1('black', 'Black')"> </td>
                            </tr>
                            <tr>
                              <td class="avocado" onclick="setColor1('avocado', 'Avocado')"> </td>
                              <td class="khaki" onclick="setColor1('khaki', 'Khaki')"> </td>
                              <td class="olive" onclick="setColor1('olive', 'Olive')"> </td>
                              <td class="nutmeg" onclick="setColor1('nutmeg', 'Nutmeg')"> </td>
                              <td class="classicburgundy" onclick="setColor1('classicburgundy', 'Classic Burgundy')"></td>
                            </tr>
                            <tr>
                              <td class="grass" onclick="setColor1('grass', 'Grass')"> </td>
                              <td class="hunter" onclick="setColor1('hunter', 'Hunter')"> </td>
                              <td class="lightblue" onclick="setColor1('lightblue', 'Light Blue')"> </td>
                              <td class="periwinkle" onclick="setColor1('periwinkle', 'Periwinkle')"> </td>
                              <td class="navy" onclick="setColor1('navy', 'Navy')"> </td>
                            </tr>
                            <tr>
                              <td class="pastelpink" onclick="setColor1('pastelpink', 'Pastel Pink')"> </td>
                              <td class="fuschia" onclick="setColor1('fuschia', 'Fuschia')"> </td>
                              <td class="orange" onclick="setColor1('orange', 'Orange')"> </td>
                              <td class="red" onclick="setColor1('red', 'Red')"> </td>
                              <td class="purple" onclick="setColor1('purple', 'Purple')"> </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <th class="selected-color" id="color1">
                          Select Main Color
                        </th>
                      </tr>
                    </table>
                  </td>
                  <td>
                    <table>
                      <tr>
                        <td>
                          <table class="swatch">
                            <tr>
                              <td class="white" onclick="setColor2('white', 'White')"> </td>
                              <td class="natural" onclick="setColor2('natural', 'Natural')"> </td>
                              <td class="grey" onclick="setColor2('grey', 'Grey')"> </td>
                              <td class="classicbrown" onclick="setColor2('classicbrown', 'Classic Brown')"> </td>
                              <td class="black" onclick="setColor2('black', 'Black')"> </td>
                            </tr>
                            <tr>
                              <td class="avocado" onclick="setColor2('avocado', 'Avocado')"> </td>
                              <td class="khaki" onclick="setColor2('khaki', 'Khaki')"> </td>
                              <td class="olive" onclick="setColor2('olive', 'Olive')"> </td>
                              <td class="nutmeg" onclick="setColor2('nutmeg', 'Nutmeg')"> </td>
                              <td class="classicburgundy" onclick="setColor2('classicburgundy', 'Classic Burgundy')"></td>
                            </tr>
                            <tr>
                              <td class="grass" onclick="setColor2('grass', 'Grass')"> </td>
                              <td class="hunter" onclick="setColor2('hunter', 'Hunter')"> </td>
                              <td class="lightblue" onclick="setColor2('lightblue', 'Light Blue')"> </td>
                              <td class="periwinkle" onclick="setColor2('periwinkle', 'Periwinkle')"> </td>
                              <td class="navy" onclick="setColor2('navy', 'Navy')"> </td>
                            </tr>
                            <tr>
                              <td class="pastelpink" onclick="setColor2('pastelpink', 'Pastel Pink')"> </td>
                              <td class="fuschia" onclick="setColor2('fuschia', 'Fuschia')"> </td>
                              <td class="orange" onclick="setColor2('orange', 'Orange')"> </td>
                              <td class="red" onclick="setColor2('red', 'Red')"> </td>
                              <td class="purple" onclick="setColor2('purple', 'Purple')"> </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <th class="selected-color" id="color2">
                          Select Second Color
                        </th>
                      </tr>
                    </table>
                  </td>
                  <td>
                    <table>
                      <tr>
                        <td>
                          <table class="swatch">
                            <tr>
                              <td class="white" onclick="setColor3('white', 'White')"> </td>
                              <td class="natural" onclick="setColor3('natural', 'Natural')"> </td>
                              <td class="grey" onclick="setColor3('grey', 'Grey')"> </td>
                              <td class="classicbrown" onclick="setColor3('classicbrown', 'Classic Brown')"> </td>
                              <td class="black" onclick="setColor3('black', 'Black')"> </td>
                            </tr>
                            <tr>
                              <td class="avocado" onclick="setColor3('avocado', 'Avocado')"> </td>
                              <td class="khaki" onclick="setColor3('khaki', 'Khaki')"> </td>
                              <td class="olive" onclick="setColor3('olive', 'Olive')"> </td>
                              <td class="nutmeg" onclick="setColor3('nutmeg', 'Nutmeg')"> </td>
                              <td class="classicburgundy" onclick="setColor3('classicburgundy', 'Classic Burgundy')"></td>
                            </tr>
                            <tr>
                              <td class="grass" onclick="setColor3('grass', 'Grass')"> </td>
                              <td class="hunter" onclick="setColor3('hunter', 'Hunter')"> </td>
                              <td class="lightblue" onclick="setColor3('lightblue', 'Light Blue')"> </td>
                              <td class="periwinkle" onclick="setColor3('periwinkle', 'Periwinkle')"> </td>
                              <td class="navy" onclick="setColor3('navy', 'Navy')"> </td>
                            </tr>
                            <tr>
                              <td class="pastelpink" onclick="setColor3('pastelpink', 'Pastel Pink')"> </td>
                              <td class="fuschia" onclick="setColor3('fuschia', 'Fuschia')"> </td>
                              <td class="orange" onclick="setColor3('orange', 'Orange')"> </td>
                              <td class="red" onclick="setColor3('red', 'Red')"> </td>
                              <td class="purple" onclick="setColor3('purple', 'Purple')"> </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <th class="selected-color" id="color3">
                          Select Third Color (Usually same as Main)
                        </th>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td colspan="2" class="center">
              <input style="font-size:large;" type="submit" name="submit" value="Submit"/>
              <input style="font-size:large;" type="button" name="cancel" 
                     onclick="history.go(-1)" value="Cancel"/>
            </td>
          </tr>
        </table>
        <input type="hidden" name="color1" value="" required/>
        <input type="hidden" name="color2" value="" required/>
        <input type="hidden" name="color3" value="" required/>
      </form>
    </div>    
  </body>
</html>
