// Importar cuando se necesite confirmar la salida de un formulario
// en proceso de creación (solo formularios sin vuejs).

$(document).ready(() => {
  window.onbeforeunload = () => '¿Seguro que deseas abandonar la página? Puede que los cambios no se hayan guardado';
  $("form").submit(() => {
    window.onbeforeunload = null;
  });
});