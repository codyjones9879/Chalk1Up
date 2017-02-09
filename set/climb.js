var boulderMode = true;   // Boulder vs Rope
var gradeMode = true;     // Grade vs Area
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
  $('.rope_grades').hide();
  $('.boulder_areas').hide();
  $('.rope_areas').hide();

  $('#type_tr').click(function(){
    console.log("Rope clicked");
    $('.boulder_grades').hide();
    $('.boulder_areas').hide();
    if(gradeMode) {
      console.log("--> Show Rope Grades");
      $('.rope_grades').show();
      $('.rope_areas').hide();
    } else {
      console.log("--> Show Rope Areas");
      $('.rope_grades').hide();
      $('.rope_areas').show();
    }
    boulderMode = false;
  });

  $('#type_b').click(function(){
    console.log("Boulder clicked");
    $('.rope_grades').hide();
    $('.rope_areas').hide();
    if(gradeMode) {
      console.log("--> Show Boulder Grades");
      $('.boulder_grades').show();
      $('.boulder_areas').hide();
    } else {
      console.log("--> Show Boulder Areas");
      $('.boulder_grades').hide();
      $('.boulder_areas').show();
    }
    boulderMode = true;
  });

  $('#type_grade').click(function(){
    console.log("Grade clicked");
    $('.boulder_areas').hide();
    $('.rope_areas').hide();
    if(boulderMode) {
      console.log("--> Show Boulder Grades");
      $('.boulder_grades').show();
      $('.rope_grades').hide();
    } else {
      console.log("--> Show Rope Grades");
      $('.boulder_grades').hide();
      $('.rope_grades').show();
    }
    gradeMode = true;
  });

  $('#type_area').click(function(){
    console.log("Area clicked");
    if(boulderMode) {
      console.log("--> Show Boulder Areas");
      $('.boulder_grades').hide();
      $('.boulder_areas').show();
    } else {
      console.log("--> Show Rope Areas");
      $('.rope_grades').hide();
      $('.rope_areas').show();
    }
    gradeMode = false;
  });
}