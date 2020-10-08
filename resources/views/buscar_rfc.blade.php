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
        h3,label {
            text-transform: uppercase;
			}
      .msj{
        color:red;
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
            
          </form>
   
            </div><!--son de la cabecera-->
                        
</div><!--container-->
         
                

     
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
