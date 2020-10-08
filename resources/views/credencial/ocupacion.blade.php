<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
    <link href="{{ asset('css/style2.css')}}" rel="stylesheet"/>
    <script type="text/javascript" src="{{ asset('js/script2.js') }}"></script>

  <title>Base64</title>


</head>
<body>

<main class="app-container">
  <img src="https://1.bp.blogspot.com/-q5KnRJYHsRc/XPiJZieNBqI/AAAAAAABNmY/_namyOSMD-wbGD7aWLTR37EMmyAZtQVTQCLcBGAs/s1600/finanzas.png" style="width: 500px;"><br>

  
  <h1>Seleccione su Ocupación</h1>
	
	<button onclick="firma()">Salir Foto</button>

   <form action="{{url('/usuario/inicio')}}">
            <input type="submit" class="btn btn-danger" value="Salir de la encuesta" />
        </form>
        <form action="{{url('/firma')}}">
            <input type="submit" class="btn btn-danger" value="Avanzar Firma" />
        </form>

        
  </div>
 
   

</main>

<!-- -->

</script>

<script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.0.5/vue.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/vue-router/2.0.1/vue-router.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.0.3/vue-resource.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/vuex/2.0.0/vuex.js'></script>
 <script type="text/javascript" src="{{ asset('js/script2.js') }}"></script>

<script type="text/javascript">

function regresar()
    {
    window.location = "{{url('/usuario/inicio')}}";
}
function firma()
    {
     window.location = "{{url('/usuario/inicio')}}";
}



     
 </script>   

 </script>   


</body>
</html>



