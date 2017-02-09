var geoCalled = false;
$(document).on('pagecreate pageinit pageshow','div:jqmData(role="page"), div:jqmData(role="dialog")', function() {
  if(!geoCalled) {
    console.log("Geolocation: About to set up...");
    getGeoLocation();
    console.log("Geolocation: Should be set up now.");
    geoCalled = true;
    $('.refreshInfo').empty();
  }
});

function getGeoLocation() {
  console.log("   getGeoLocation()");
  if (navigator.geolocation) {
    console.log("      We have geolocation");
    var info = "By allowing us access to your location, we can determine which climbing gym you are at, and save you time!"
    $(".geolocInfo").text(info);
    navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
  } else {
    var info = "Geolocation not supported";
    console.log("      "+info);
    $(".geolocInfo").text(info);
    alert('Geolocation makes logging a climb less work for you, but your browser doesn&apos;t support it. Try it with a browser that does, such as Opera 10.60.');
  }
}

function successFunction(position) {
  var lat = position.coords.latitude;
  var long = position.coords.longitude;

  $("#Lat").val(lat);
  $("#Long").val(long);

  var info = "Your GPS location is ("+lat+", "+long+").  When you sign in, we will use your GPS to set the gym for you!";
  $(".geolocInfo").text(info);
}

function errorFunction(error) {
  $(".geolocInfo").text("Geolocation error!");
  switch(error.code){
  case error.PERMISSION_DENIED:
    $(".geolocInfo").text("Geolocation: Permission Denied");
    break;
  case error.POSITION_UNAVAILABLE:
    $(".geolocInfo").text("Geolocation: Position unavailable");
    break;
  case error.TIMEOUT:
    $(".geolocInfo").text("Geolocation: Timeout");
    break;
  case error.UNKNOW_ERROR:
    $(".geolocInfo").text("Geolocation: Unknown error");
    break;        
  }
}