var sortForerun = true; // Sort by Forerun or Strip
var what = 0;   // 0: Boulder, 1: Rope, 2: All
var who = 1;    // 0: Mine, 1: Others, 2: All
var clickCalled = false;

$(document).live('pagecreate pageinit pageshow', function() {
  if(!clickCalled) {
    console.log("Calling setupOnClicks...");
    setupOnClicks();
    console.log("OnClicks should be setup now");
    clickCalled = true;
    $('.refreshInfo').empty();
    $('.refreshToShow').show();
  }
});

function setupOnClicks() {
  console.log("setupOnClicks()");
  $('.rope').hide();
  $('.mine').hide();
  $('.sort_strip').hide();

  $('#sort_forerun').click(function(){
    console.log("Forerun clicked");
    $('.sort_strip').hide();
    $('.sort_forerun').show();
    sortForerun = true;
    
    if(what == 1) {
      $('.boulder').hide();
    } else if(what == 0) {
      $('.rope').hide();
    }

    if(who == 1) {
      $('.mine').hide();
    } else if(who == 0) {
      $('.others').hide();
    }
  });
  $('#sort_strip').click(function(){
    console.log("Strip clicked");
    $('.sort_forerun').hide();
    $('.sort_strip').show();
    sortForerun = false;

    if(what == 1) {
      $('.boulder').hide();
    } else if(what == 0) {
      $('.rope').hide();
    }

    if(who == 1) {
      $('.mine').hide();
    } else if(who == 0) {
      $('.others').hide();
    }
  });

  $('#type_b').click(function(){
    console.log("Boulder clicked");
    $('.rope').hide();
    $('.boulder').show();
    what = 0;

    if(who == 1) {
      $('.mine').hide();
    } else if(who == 0) {
      $('.others').hide();
    }
  });
  $('#type_r').click(function(){
    console.log("Rope clicked");
    $('.boulder').hide();
    $('.rope').show();
    what = 1;

    if(who == 1) {
      $('.mine').hide();
    } else if(who == 0) {
      $('.others').hide();
    }
  });
  $('#type_both').click(function(){
    console.log("Both clicked");
    $('.boulder').show();
    $('.rope').show();
    what = 2;

    if(who == 1) {
      $('.mine').hide();
    } else if(who == 0) {
      $('.others').hide();
    }
  });

  $('#set_by_me').click(function(){
    console.log("Mine clicked");
    $('.others').hide();
    $('.mine').show();
    who = 0;

    if(what == 1) {
      $('.boulder').hide();
    } else if(what == 0) {
      $('.rope').hide();
    }
  });
  $('#set_by_others').click(function(){
    console.log("Others clicked");
    $('.mine').hide();
    $('.others').show();
    who = 1;

    if(what == 1) {
      $('.boulder').hide();
    } else if(what == 0) {
      $('.rope').hide();
    }
  });
  $('#set_by_all').click(function(){
    console.log("All clicked");
    $('.mine').show();
    $('.others').show();
    who = 2;

    if(what == 1) {
      $('.boulder').hide();
    } else if(what == 0) {
      $('.rope').hide();
    }
  });
}