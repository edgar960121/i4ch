<?php 
$datos = json_decode($informacion, true);
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Capital Humano - Secretaría de Finanzas</title>
        

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
       /* h3,label {
            text-transform: uppercase;
			}*/
            body
{
    background-color: black; /* La página de fondo será negra */
    color: white; /*El texto de la página será blanco */
}
            
        </style>
        
    </head>
    
    <body>
    <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <img src="{{url('/assets/template/images/Logo_ch.svg')}}" width="80" alt="">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <div class="header-logo-name" style="margin-left:-3px">
        <span><b>Capital Humano</b></span></br>
        <small ><b>Secretaría de Administración y Finanzas</b></small>
        
      </div>
    </ul>
    <!--Regresar a la ruta anterior-->
    <form class="form-inline my-2 my-lg-0">
      <a href="{{ url('/usuario/inicio') }}" type="button" class="btn btn-primary" style="border-color:#31b700; background-color: #31b700;" >Regresar</a>
    </form>
  </div>
</nav>  

@csrf
<?php //var_dump($datos)?>


<!--Buscar el RFC-->
<form action="{{'/usuario/inicio/datosusuarios'}}" method="post">
          <h6>Consulta por RFC </h6>

          <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <input type="text" name="RFC" placeholder="Inserte RFC"  value="{{ old('RFC')}}"><br>
            {!! $errors->first('RFC','<small class="msj" >:message</small>') !!} <br>
              <button class="btn btn-primary" style="border-color:#31b700; background-color: #31b700;">Buscar 
              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
  <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
</svg></button>
            
          


             <div class="mt-4">
            <div class="card-primary" style="background-color:#31b700;">
                <div class="card-header">
                    <h5 class="card-title" style="color:white;" >Datos del usuario</h5>
                </div>
                </div>
            
            <div class="card-primary" style="background-color:#F5FCFE;">
            <div class="row">
                <div class="col">
            <label class="control-label" for="curp">CURP:</label>
            <input class="form-control" id="curp" type="text" name="curp" value="<?php if(isset($datos['data']['CURP'])){
                echo $datos['data']['CURP']; }else{echo "";} ?>">
            
                </div>
                <div class="col">
            <label class="control-label" for="curp">Nombres:</label>
            <input class="form-control" id="curp" type="text" name="curp" value="<?php if(isset($datos['data']['nombres_RENAPO'])){
                echo $datos['data']['nombres_RENAPO']; }else{echo "";} ?>">
                </div>
                <div class="col">
            <label class="control-label" for="nombre">Apellido paterno:</label>
            <input class="form-control" id="nombre" type="text" name="nombre" value="<?php if(isset($datos['data']['apellidoPaterno_RENAPO'])){
                echo $datos['data']['apellidoPaterno_RENAPO']; }else{echo "";} ?>">
                </div>
                <div class="col">
            <label class="control-label" for="nombre">Apellido materno:</label>
            <input class="form-control" id="nombre" type="text" name="nombre" value="<?php if(isset($datos['data']['apellidoMaterno_RENAPO'])){
                echo $datos['data']['apellidoMaterno_RENAPO']; }else{echo "";} ?>">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col">
                <label class="control-label" for="nombre">Número de empleado:</label>
                <input class="form-control" id="nombre" type="text" name="numempleado" value="<?php if(isset($datos['data']['NumEmpleado'])){
                echo $datos['data']['NumEmpleado']; }else{echo "";} ?>">
                    </div>

                    <div class="col">
                <label class="control-label" for="puesto">Código puesto:</label>
                <input class="form-control" id="puesto" type="text" name="puesto" value="<?php if(isset($datos['data']['COD_PUESTO_CVE_ACT'])){
                echo $datos['data']['NumEmpleado']; }else{echo "";} ?>">
                    </div>

                    <div class="col">
            <label class="control-label" for="F_laboral">Fecha de Inicio laboral:</label>
            <input class="form-control" id="F_laboral" type="text" name="F_laboral" value="<?php if(isset($datos['data']['FECHAINICIOREALLABORAL'])){
                echo $datos['data']['FECHAINICIOREALLABORAL']; }else{echo "";} ?>">
                </div>

                <div class="col">
            <label class="control-label" for="u_adm">Unidad Administrativa:</label>
            <input class="form-control" id="u_adm" type="text" name="u_adm" value="<?php if(isset($datos['data']['UNIDAD_ADM'])){
                echo $datos['data']['UNIDAD_ADM']; }else{echo "";} ?>">
                </div>
            </div>

            <div class="row mt-2">
            <div class="col">
            <label class="control-label" for="rfc">RFC:</label>
            <input class="form-control" id="rfc" type="text" name="rfc" value="<?php if(isset($datos['data']['RFC'])){
                echo $datos['data']['RFC']; }else{echo "";} ?>">
                </div>

                <div class="col">
            <label class="control-label" for="riesgo">Riesgo, puesto:</label>
            <input class="form-control" id="riesgo" type="text" name="riesgo" value="<?php if(isset($datos['data']['RIESGOPUESTO'])){
                echo $datos['data']['RIESGOPUESTO']; }else{echo "";} ?>">
                </div>

            <div class="col">
            <label class="control-label" for="sindicalizado">Es sindicalizado:</label>
            <input class="form-control" id="sindicalizado" type="text" name="sindicalizado" value="<?php if(isset($datos['data']['SINDICALIZADO'])){
                echo $datos['data']['SINDICALIZADO']; }else{echo "";} ?>">
                </div>

                <div class="col">
            <label class="control-label" for="contratacion">Tipo de Contratación:</label>
            <input class="form-control" id="contratacion" type="text" name="contratacion" value="<?php if(isset($datos['data']['TIPOCONTRATO'])){
                echo $datos['data']['TIPOCONTRATO']; }else{echo "";} ?>">
                </div>
            </div>

            <div class="row mt-2">
            <div class="col">
            <label class="control-label" for="num_plaza">Número de plaza:</label>
            <input class="form-control" id="num_plaza" type="text" name="num_plaza" value="<?php if(isset($datos['data']['NUM_PLAZA'])){
                echo $datos['data']['NUM_PLAZA']; }else{echo "";} ?>">
                </div>

                <div class="col">
            <label class="control-label" for="universo">Universo:</label>
            <input class="form-control" id="universo" type="text" name="universo" value="">
                </div>
           
                <div class="col">
            <label class="control-label" for="departamento">Departamento:</label>
            <input class="form-control" id="departamento" type="text" name="departamento" value="<?php if(isset($datos['data']['DEPARTAMENTO'])){
                echo $datos['data']['DEPARTAMENTO']; }else{echo "";} ?>">
                </div>
                <div class="col">
            <label class="control-label" for="antiguedad">Antiguedad:</label>
            <input class="form-control" id="antiguedad" type="text" name="antiguedad" value="<?php if(isset($datos['data']['ANTIGUEDAD'])){
                echo $datos['data']['ANTIGUEDAD']; }else{echo "";} ?>">
                </div>
            </div>

            <div class="row mt-2">
                <div class="col">
            <label class="control-label" for="nom_u_adm">Nombre de la unidad administrativa:</label>
            <input class="form-control" id="nom_u_adm" type="text" name="nom_u_adm" value="<?php if(isset($datos['data']['N_UNIDAD_ADM'])){
                echo $datos['data']['N_UNIDAD_ADM']; }else{echo "";} ?>">
                </div>

                <div class="col">
            <label class="control-label" for="sector">Nombre del sector adscrito al gobierno:</label>
            <input class="form-control" id="sector" type="text" name="sector" value="">
                </div>
                <div class="col">
            <label class="control-label" for="sun">Número de identificación de Sector (SUN):</label>
            <input class="form-control" id="sun" type="text" name="sun" value="">
                </div>
                <div class="col">
            <label class="control-label" for="n_salarial">Nivel Salarial:</label><br><br>
            <input class="form-control" id="n_salarial" type="text" name="n_salarial" value="<?php if(isset($datos['data']['NIVEL_SALARIAL'])){
                echo $datos['data']['NIVEL_SALARIAL']; }else{echo "";} ?>">
                </div>

              
            </div>

            <div class="row mt-2">
                <div class="col">
            <label class="control-label" for="jornada">Tipo de jornada:</label>
            <input class="form-control" id="jornada" type="text" name="jornada" value="<?php if(isset($datos['data']['TIPOJORNADA'])){
                echo $datos['data']['TIPOJORNADA']; }else{echo "";} ?>">
                </div>

                <div class="col">
            <label class="control-label" for="zona_pagadora">Zona pagadora:</label>
            <input class="form-control" id="zona_pagadora" type="text" name="zona_pagadora" value="<?php if(isset($datos['data']['ZONA_PAGADORA'])){
                echo $datos['data']['ZONA_PAGADORA']; }else{echo "";} ?>">
                </div>
                <div class="col">
            <label class="control-label" for="tipo_contrato">Tipo de contrato:</label>
            <input class="form-control" id="tipo_contrato" type="text" name="tipo_contrato" value="<?php if(isset($datos['data']['TIPOCONTRATO'])){
                echo $datos['data']['TIPOCONTRATO']; }else{echo "";} ?>">
                </div>    
                <div class="col">
            <label class="control-label" for="status">Status:</label>
            <input class="form-control" id="status" type="text" name="status" value="<?php if(isset($datos['data']['status'])){
                echo $datos['data']['status']; }else{echo "";} ?>">
                </div>           
            </div>

            <div class="row mt-2">
                <div class="col">
            <label class="control-label" for="status">Tipo nómina:</label>
            <input class="form-control" id="status" type="text" name="status" value="<?php if(isset($datos['data']['tipoNomina'])){
                echo $datos['data']['tipoNomina']; }else{echo "";} ?>">
                </div>

                <div class="col">
            <label class="control-label" for="status">Último recibo:</label>
            <input class="form-control" id="status" type="text" name="status" value="<?php if(isset($datos['data']['lastReceipt'])){
                echo $datos['data']['lastReceipt']; }else{echo "";} ?>">
                </div>

                <div class="col">
            <label class="control-label" for="status">Cargado:</label>
            <input class="form-control" id="status" type="text" name="status" value="<?php if(isset($datos['data']['loadedBy'])){
                echo $datos['data']['loadedBy']; }else{echo "";} ?>">
                </div>
            </div>

            <div class="row mt-2">
                <div class="col">
                <label class="control-label" for="name_puesto">Nombre puesto funcional:</label>
                <input class="form-control" id="name_puesto" type="text" name="name_puesto" value="<?php if(isset($datos['data']['N_PUESTO_COM'])){
                echo $datos['data']['N_PUESTO_COM']; }else{echo "";} ?>">
                </div>

                <div class="col">
                <label class="control-label" for="name_nominal">Nombre puesto nominal:</label>
                <input class="form-control" id="name_nominal" type="text" name="name_nominal" value="<?php if(isset($datos['data']['N_PUESTO_ACT_ASOC_PROG'])){
                echo $datos['data']['N_PUESTO_ACT_ASOC_PROG']; }else{echo "";} ?>">
                </div>
            
            </div>
            <br>
               
            </form>
            
</div><!--container-->
   
            </div><!--son de la cabecera-->
            </div>
            </div>
                
</div><br>
     
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
