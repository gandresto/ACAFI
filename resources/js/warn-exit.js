// window.onbeforeunload = () => '¿Seguro que deseas abandonar la página, los cambios hechos se perderán?';
var submitted = false;
 
$(document).ready(function() {
  $("form").submit(function() {
    submitted = true;
  });
 
  window.onbeforeunload = function () {
    if (!submitted) {
      return 'Do you really want to leave the page?';
    }
  }
});