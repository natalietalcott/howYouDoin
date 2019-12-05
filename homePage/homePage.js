$(document).ready(function() {
  $("#log").click(function() {
    $("#log_sidebar").css("width", "25%");
  });
  $("#closebtn").click(function() {
    $("#log_sidebar").css("width", "0%");
  });

  $("#filter").click(function() {
    $("#filter_sidebar").css("width", "25%");
  });
  $("#fclosebtn").click(function() {
    $("#filter_sidebar").css("width", "0%");
  });

});
