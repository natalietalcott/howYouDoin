$(document).ready(function() {
  //$("#log_sidebar").hide();
  $("#log").click(function() {
    $("#log_sidebar").css("width", "25%");
  });
  $("#closebtn").click(function() {
    $("#log_sidebar").css("width", "0%");
  });
  /*
  $("#super_sad").click(function() {
    console.log("Here");
    $("#emoticon").value("super_sad");
  });
  */
});
