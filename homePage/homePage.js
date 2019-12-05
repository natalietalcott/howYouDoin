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

  // Get the modal
  var modal = document.getElementById("myModal");

  // Get the button that opens the modal
  var btn = document.getElementById("myBtn");

  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];

  // When the user clicks on the button, open the modal
  btn.onclick = function() {
    modal.style.display = "block";
  };

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
  };

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };
});
