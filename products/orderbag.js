sessionStorage.color1;
sessionStorage.color2;
sessionStorage.color3;
sessionStorage.color1text;
sessionStorage.color2text;
sessionStorage.color3text;

function setColor1(newclass, newtext) {
  var concatclass = "selected-color " + newclass;
  document.getElementById("color1").setAttribute("class", concatclass);
  document.getElementById("color1").innerHTML = newtext;
  document.forms[0].elements['color1'].value = newtext;
  sessionStorage.color1=newclass;
  sessionStorage.color1text=newtext;
  updateSampleBag(350);
}
function setColor2(newclass, newtext) {
  var concatclass = "selected-color " + newclass;
  document.getElementById("color2").setAttribute("class", concatclass);
  document.getElementById("color2").innerHTML = newtext;
  document.forms[0].elements['color2'].value = newtext;
  sessionStorage.color2=newclass;
  sessionStorage.color2text=newtext;
  updateSampleBag(350);
}
function setColor3(newclass, newtext) {
  var concatclass = "selected-color " + newclass;
  document.getElementById("color3").setAttribute("class", concatclass);
  document.getElementById("color3").innerHTML = newtext;
  document.forms[0].elements['color3'].value = newtext;
  sessionStorage.color3=newclass;
  sessionStorage.color3text=newtext;
  updateSampleBag(350);
}
function validateColors() {
  if (!sessionStorage.color1) {
    document.getElementById("color1").style.border = '3px solid red';
    alert("Please select a main color");
    document.getElementById("color1").style.border = '1px solid black';
    return false;
  }
  if (!sessionStorage.color2) {
    document.getElementById("color2").style.border = '3px solid red';
    alert("Please select a second color");
    document.getElementById("color2").style.border = '1px solid black';
    return false;
  }
  if (!sessionStorage.color3) {
    document.getElementById("color3").style.border = '3px solid red';
    alert("Please select a third color");
    document.getElementById("color3").style.border = '1px solid black';
    return false;
  }
  return true;
}
function restoreColors() {
  if(sessionStorage.color1)
    setColor1(sessionStorage.color1, sessionStorage.color1text);
  if(sessionStorage.color2)
    setColor2(sessionStorage.color2, sessionStorage.color2text);
  if(sessionStorage.color3)
    setColor3(sessionStorage.color3, sessionStorage.color3text);
}
function updateSampleBag(width) {
  var c=document.getElementById("sampleBag");
  var cxt=c.getContext("2d");
  var height=width*8/15;
  c.width = width;
  c.height = height;
        
  color1 = getElementBackground(document.getElementById("color1"));
  color2 = getElementBackground(document.getElementById("color2"));
  color3 = getElementBackground(document.getElementById("color3"));
        
  var frontx = width*1/3;
  var fronty = height*3/5-height*1/12;
  var backx = width*1/3;
  var backy = 0+height*1/18;
  var leftx = 0;
  var lefty = height*1/3;
  var rightx = width*2/3;
  var righty = height*1/3;
        
  var w = width/3;
  var h = height*2/5;
        
  // Labels
  cxt.textBaseline = "bottom";
  cxt.textAlign = "center";
  cxt.fillText("Front", frontx+w/2, height);
  cxt.fillText("Back", backx+w/2, backy);
  cxt.fillText("Left", leftx+w/2, lefty);
  cxt.fillText("Right", rightx+w/2, righty);
        
        
  // First Color
  cxt.strokeStyle = "black";
  cxt.fillStyle = color1;
  // Front
  cxt.beginPath();
  cxt.moveTo( frontx+(0.06*w),fronty+(0.75*h));
  cxt.lineTo( frontx+(0.2*w),fronty+0);
  cxt.lineTo( frontx+(0.8*w),fronty+0);
  cxt.lineTo( frontx+(0.94*w),fronty+(0.75*h));
  cxt.quadraticCurveTo(frontx+(0.6*w), fronty+(0.75*h), frontx+(0.5*w), fronty+(0.5*h));
  cxt.quadraticCurveTo(frontx+(0.4*w), fronty+(0.75*h), frontx+(0.06*w),fronty+(0.75*h));
  cxt.closePath();
  cxt.stroke();
  cxt.fill();
  // Left
  cxt.beginPath();
  cxt.moveTo(leftx+(0.8*w),lefty+0);
  cxt.lineTo(leftx+(0.2*w),lefty+0);
  cxt.quadraticCurveTo(leftx+(0.6*w), lefty+(0.1*h), leftx+(0.92*w),lefty+(0.6*h));
  cxt.lineTo(leftx+(0.8*w),lefty+0);
  cxt.closePath();
  cxt.stroke();
  cxt.fill();
  // Right
  cxt.beginPath();
  cxt.moveTo(rightx+(0.2*w),righty+0);
  cxt.lineTo(rightx+(0.8*w),righty+0);
  cxt.quadraticCurveTo(rightx+(0.4*w),righty+(0.1*h),rightx+(0.08*w),righty+(0.6*h));
  cxt.lineTo(rightx+(0.2*w),righty+0);
  cxt.closePath();
  cxt.stroke();
  cxt.fill();
  // Back
  // NONE

  // Second Color
  cxt.strokeStyle="black";
  cxt.fillStyle = color2;
  // Front
  cxt.beginPath();
  cxt.moveTo(frontx+(0.94*w),fronty+(0.75*h));
  cxt.quadraticCurveTo(frontx+(0.6*w), fronty+(0.75*h), frontx+(0.5*w), fronty+(0.5*h));
  cxt.quadraticCurveTo(frontx+(0.4*w), fronty+(0.75*h), frontx+(0.06*w),fronty+(0.75*h));
  cxt.lineTo(frontx+(0.06*w),fronty+(0.75*h));
  cxt.lineTo(frontx+0,fronty+(h));
  cxt.lineTo(frontx+(w),fronty+(h));
  cxt.lineTo(frontx+(0.94*w),fronty+(0.75*h));
  cxt.closePath();
  cxt.stroke();
  cxt.fill();
  // Left
  cxt.beginPath();
  cxt.moveTo(leftx+(0.2*w),lefty+0);
  cxt.quadraticCurveTo(leftx+(0.6*w), lefty+(0.1*h), leftx+(0.92*w),lefty+(0.6*h));
  cxt.lineTo(leftx+(w),lefty+(h));
  cxt.quadraticCurveTo(leftx+(0.5*w),lefty+(0.5*h), leftx+(0.1*w),lefty+(0.5*h));
  cxt.lineTo(leftx+(0.2*w),lefty+0);
  cxt.closePath();
  cxt.stroke();
  cxt.fill();
  //Right
  cxt.beginPath();
  cxt.moveTo(rightx+(0.08*w),righty+(0.6*h));
  cxt.quadraticCurveTo(rightx+(0.4*w),righty+(0.1*h),rightx+(0.8*w),righty+0);
  cxt.lineTo(rightx+(0.9*w),righty+(0.5*h));
  cxt.quadraticCurveTo(rightx+(0.5*w),righty+(0.5*h),rightx+0,righty+(h));
  cxt.lineTo(rightx+(0.1*w),righty+(0.5*h));
  cxt.closePath();
  cxt.stroke();
  cxt.fill();
  // Back
  cxt.beginPath();
  cxt.moveTo(backx+(0.2*w),backy+0);
  cxt.lineTo(backx+(0.8*w),backy+0);
  cxt.lineTo(backx+(0.9*w),backy+(0.5*h));
  cxt.quadraticCurveTo(backx+(0.7*w),backy+(0.6*h),backx+(0.6*w),backy+(h));
  cxt.lineTo(backx+(0.4*w),backy+(h));
  cxt.quadraticCurveTo(backx+(0.3*w),backy+(0.6*h),backx+(0.1*w),backy+(0.5*h));
  cxt.lineTo(backx+(0.2*w),backy+0);
  cxt.closePath();
  cxt.stroke();
  cxt.fill();
						
				
  // Third Color
  cxt.strokeStyle="black";
  cxt.fillStyle = color3;
  // Front
  // NONE
  // Left
  cxt.beginPath();
  cxt.moveTo(leftx+(w),lefty+(h));
  cxt.quadraticCurveTo(leftx+(0.5*w),lefty+(0.5*h), leftx+(0.1*w),lefty+(0.5*h));
  cxt.lineTo(leftx+0,lefty+(h));
  cxt.lineTo(leftx+(w),lefty+(h));
  cxt.closePath();
  cxt.stroke();
  cxt.fill();
  // Right
  cxt.beginPath();
  cxt.moveTo(rightx+0,righty+(h));
  cxt.quadraticCurveTo(rightx+(0.5*w),righty+(0.5*h),rightx+(0.9*w),righty+(0.5*h));
  cxt.lineTo(rightx+(w),righty+(h));
  cxt.lineTo(rightx+0,righty+(h));
  cxt.closePath();
  cxt.stroke();
  cxt.fill();
  // Back
  cxt.beginPath();
  cxt.moveTo(backx+(0.4*w),backy+(h));
  cxt.quadraticCurveTo(backx+(0.3*w),backy+(0.6*h),backx+(0.1*w),backy+(0.5*h));
  cxt.lineTo(backx+0,backy+(h));
  cxt.lineTo(backx+(w),backy+(h));
  cxt.lineTo(backx+(0.9*w),backy+(0.5*h));
  cxt.quadraticCurveTo(backx+(0.7*w),backy+(0.6*h),backx+(0.6*w),backy+(h));
  cxt.closePath();
  cxt.stroke();
  cxt.fill();
}