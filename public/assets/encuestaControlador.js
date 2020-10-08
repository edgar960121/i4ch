/*En cuanto carga el DOM se ejecutan
  todas las instrucciones que escribas
  dentro de esta función*/
$(document).ready(function () {
  //En este caso quiero que se escondan algunos DIVS del DOM
  $("#paso2").hide();
});



/* Esta funcion serializa todas las respuestas. */
function finalizaEncuesta() {

  var datos = new FormData(document.getElementById("saveCuestionario"));
  //Envio todos los input a la fución ajax
  ajaxCuestionario(datos).done(function (data) {
    //si el servidor no responde ningún error, entrará aquí

    $("#paso1").hide();
    $("#paso2").show();


  }).fail(function (data) {
    alert('Error inesperado, cierre su navegador y vuelva a intentar.');
  });

}


/* Aquí envías de forma asincrona los datos,
   Significa que el front hace peticiones al back sin la necesidad
   de recargar la página */
function ajaxCuestionario(datos) {
  return $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: "POST",
    data: datos,
    contentType: false,
    processData: false,
    async: true,
    url: '/cuestionarioAjax',
  });
}