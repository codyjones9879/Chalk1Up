function disclaimer() {
  window.alert("Please give your name and design request for your boulder bucket. Please note that we do NOT guarantee the completion of any bag. See the Products tab for more info...\n\
If nothing happens, setup a new email to  contact@chalk1up.net  to place your order.");
  newwindow=window.open("/products/orderbag_popup.html", 'Boulder Bucket Order Form');
  if (window.focus) {
    newwindow.focus()
  }
  return false;
}
function confirmSubmit() {
  var agree=confirm("Are you sure you wish to continue?");
  if (agree)
    return true;
  else
    return false;
}
function ShowItem(itemID) {
  var x = document.getElementById(itemID);
  if (x)
    x.style.visibility = "visible";
  return true;
}
function HideItem(itemID) {
  var x = document.getElementById(itemID);
  if (x)
    x.style.visibility = "hidden";
  return true;
}
function getElementBackground(el) {
  if(el.currentStyle)
    return el.currentStyle.backgroundColor;
  if(document.defaultView)
    return document.defaultView.getComputedStyle(el, '').getPropertyValue("background-color");
  return "Unable to get element color";
}
function setMainImage(newText, newImage) {
  var els = document.getElementById('mainImage').getElementsByTagName("*");
  var h = els[0];
  var img = els[1];
  img.src = newImage;
  h.innerText = newText;
}
function setColorChoices(thumbs, images, texts, price, sizes) {
  var ths = thumbs.split(",");
  var ims = images.split(",");
  var txt = texts.split(",");
  var cols = 3;
  var rows = Math.ceil(ths.length/cols);
  var lastRow = ths.length%cols;
  var o = document.getElementById("colorChoices");
  o.innerHtml="";
  o.innerText="";

  // Set the Price and Available Sizes
  document.getElementById('price').innerText = price;
  document.getElementById('sizes').innerText = sizes;

  var html="";
  var i;
  for (i=0; i < ths.length; i++) {
    if(i%cols == 0) {

    }
    var imag = document.createElement("img");
    imag.setAttribute('src', ths[i]);
    imag.setAttribute('class', 'shirt-thumb');
    imag.setAttribute('alt', txt[i]);
    imag.setAttribute('title', txt[i]);
    imag.onclick = Function("setMainImage("+"'"+txt[i]+"', '"+ims[i]+"'); return false");
    
    var anch = document.createElement("a");
    anch.setAttribute('href', '#');
    anch.appendChild(imag);
    o.appendChild(anch);
  }
}
