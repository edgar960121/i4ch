$(document).ready(function () {
  $("#paso2").hide();
  $("#paso3A").hide();
  $("#paso3B").hide();
  $("#paso3C").hide();
  $("#paso3D").hide();
  $("#paso3E").hide();
  $("#paso4").hide();



});

function paso1() {

  $("#paso2").show();
  $("#trueDiscapacidad").hide();
  $("#trueDiscapacidadSelectAyuda").hide();
  $("#inputOtraDisc").hide();
  $("#limitacionFisica").hide();
  $("#divLimitacionFisica").hide();
  $("#divLimitacionFisicaOtra").hide();
  $("#divnivelestudios").hide();
  $("#divconcluiroCertificar").hide();
  $("#buttonpaso2").hide();
  $("#divactividadesPrincipales").hide();
  $("#divTecnicoEstructura").hide();

  $("#paso1").hide();
  $("#cancelar").show();

}

function actprinc(e) {
  if (e == '') {
    alert('seleccione una opción por favor');
    
    return false;
  }

  if (e != '') {
    $("#buttonpaso2").show();
  }

}

function paso2() {

  if ($("#nombre").val() <= null) {
    alert('aún faltan campos por contestar')
    return false
  } else if ($("#appat").val() <= null) {
    alert('aún faltan campos por contestar')
    return false
  } else if ($("#apmat").val() <= null) {
    alert('aún faltan campos por contestar')
    return false
  } else if ($("#genero").val() <= null) {
    alert('aún faltan campos por contestar')
    return false
  } else {


    $("#paso2").hide();

    if($("#selectTecnicoEstructura").val() == 'Estructura'){
      $("#paso3E").show();
    }
    else{
      var prueba = $("input[name='actividadesPrincipales']:checked").val();
      if (prueba == 'A') {
        $("#paso3A").show();
      } else if (prueba == 'B') {
        $("#paso3B").show();
      } else if (prueba == 'C') {
        $("#paso3C").show();
      } else if (prueba == 'D') {
        $("#paso3D").show();
      }

    }
  
  }

}

function paso3() {
 
  // var nextquest = $("#actividadesPrincipales").val();
  var nextquest = $("input[name='actividadesPrincipales']:checked").val();
  if (nextquest == 'A') {

    if ($("#nivel_inconcluso1").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso2").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso3").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso7").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso25").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso26").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso27").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso28").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso29").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else {
      $("#paso4").show();
      $("#paso3A").hide();
    }
  } else if (nextquest == 'B') {
    if ($("#nivel_inconcluso1B").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso2B").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso3B").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso7B").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso25B").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso26B").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso27B").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso28B").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso29B").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso30B").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    }else if ($("#nivel_inconcluso31B").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    }else if ($("#nivel_inconcluso32B").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    }  else {
      $("#paso4").show();
      $("#paso3B").hide();
    }

  } else if (nextquest == 'C') {
    if ($("#nivel_inconcluso1C").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso2C").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso3C").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso7C").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso25C").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso26C").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso27C").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso28C").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso29C").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso30C").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    }else {
      $("#paso4").show();
      $("#paso3C").hide();
    }
  } else if (nextquest == 'D') {
    if ($("#nivel_inconcluso1D").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso2D").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso3D").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso7D").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso25D").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso26D").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso27D").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso28D").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso29D").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso30D").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso31D").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso32D").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else {
      $("#paso4").show();
      $("#paso3D").hide();
    }
  } else {
    if ($("#nivel_inconcluso1E").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso2E").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso3E").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso7E").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso25E").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso26E").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso27E").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso28E").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso29E").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso30E").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso31E").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else if ($("#nivel_inconcluso32E").val() == null) {
      alert('aún faltan campos por contestar')
      return false
    } else {
      $("#paso4").show();
      $("#paso3E").hide();
    }
  } 

}

function validapaso2(e) {
  if (e != '') {
    $("#automovil").show(); //muestra el div para cargar un xml correspondiente a un vehiculo
    $("#seleccion_operacion").hide(); //esconde el div de seleccion original
  }
}

function Discapacidad(e) {
  if (e == '') {
    alert('seleccione una opción por favor');
    return false;
  }
  if (e == 'Si Discapacidad') {
    $("#trueDiscapacidad").show();
    $("#trueDiscapacidadSelectAyuda").show();
    $("#limitacionFisica").show();


  }
  if (e == 'No Discapacidad') {
    $("#trueDiscapacidad").hide();
    $("#trueDiscapacidadSelectAyuda").hide();
    $("#inputOtraDisc").hide();
    $("#limitacionFisica").show();
    $("#discapacidadSelect").val('');
    $("#discapacidadSelectAyuda").val('');
    $("#OtraDiscapacidadNecesidad").val('');




  }
}

function otraDiscapacidad(e) {
  if (e == 'Otra, ¿cuál?') {
    $("#inputOtraDisc").show();
  }
}

function DiscapacidadFisica(e) {
  if (e == '') {
    alert('seleccione una opción por favor');
    return false;
  }
  if (e == 'Si limitacion') {
    $("#divLimitacionFisica").show();
    $("#divnivelestudios").show();



  }
  if (e == 'No limitacion') {
    $("#divLimitacionFisica").hide();
    $("#divnivelestudios").show();
    $("#divLimitacionFisicaOtra").hide();

  }
}

function LimitacionFisica(e) {
  if (e == 'Otras (especificar)') {
    $("#divLimitacionFisicaOtra").show();
  }
  if (e != 'Otras (especificar)') {
    $("#divLimitacionFisicaOtra").hide();
  }
}

function nivelEstudios(e) {
  if (e == '') {
    alert('seleccione una opción por favor');
    return false;
  }
  if (e != '') {
    $("#divconcluiroCertificar").show();
  }

}

function concluirCertificar(e) {
  if (e == '') {
    alert('seleccione una opción por favor');
    return false;
  }
  if (e != '') {
    $("#divTecnicoEstructura").show();
  }
}

function tecnicoEstructura(e) {
  if (e == '') {
    alert('seleccione una opción por favor');
    return false;
  }
  else if (e == 'TecnicoOperativo') {
    $("#divactividadesPrincipales").show();
    $("#buttonpaso2").hide();
  }
  else if (e == 'Estructura'){
    $("#buttonpaso2").show();
    $("#divactividadesPrincipales").hide();
  }
}

function valida21(e) {
  var datos = new FormData(document.getElementById("saveCuestionario"));
  ajaxCuestionario(datos).done(function (data) {
    window.location = "/usuario/inicio";
  }).fail(function (data) {
    console.log(window.location.hostname);
   window.location = "/usuario/inicio";
  });


}

function ajaxCuestionario(datos) {
  return $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: "POST",
    data: datos,
    contentType: false,
    processData: false,
    url: '/cuestionarioAjax',
  });
}