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
  
  <h1>Img Base64</h1>
	<img src="https://1.bp.blogspot.com/-q5KnRJYHsRc/XPiJZieNBqI/AAAAAAABNmY/_namyOSMD-wbGD7aWLTR37EMmyAZtQVTQCLcBGAs/s1600/finanzas.png" style="width: 500px;"><br>

<!--	<button onclick="firma()">Salir Foto</button> -->

   <form action="{{url('/usuario/inicio')}}">
            <input type="submit" class="btn btn-danger" value="Regresar" />
        </form><br>
      
  </div>
  <div id="app">
      <form action="{{url('/firma')}}" method="post">
           {{ csrf_field() }}
    <image-uploader 
      width="300px" 
      height="200px">
    </image-uploader>

    <section class="text-area-section">

      <textarea name="txtArea" v-model="sharedData.imageData">

       
      </textarea>

    </section>
    <input type="submit" class="btn btn-danger" value="Avanzar Firma" />
        </form>

</main>


<!-- -->
<script type="text/x-template" id="image-uploader-template">

<div class="image-input__container image-uploader" 
	v-bind:style="containerStyles" 
  v-bind:class="{ 'image-loaded': isImageLoaded }">

    <!-- Hidden input we use to access file contents -->
    <form class="image-input__form" ref="form" style="background-color:coral;">
      <input @change="previewThumbnail" class="image-input__input" ref="fileInput" type="file" />
    </form>
    <div v-on:click="triggerInput" class="image-input__overlay"></div>
    <div class="image-input__control-buttons">
    	<button v-on:click="toBase64" type="button" class="to-base64">64</button>
      <button v-on:click="scaleUp" type="button" class="scale-up">+</button>
      <button v-on:click="scaleDown" type="button" class="scale-down">-</button>
      <button v-on:click="resetInput" type="button" class="reset-input">x</button>
    </div>

<input type="submit" class="btn btn-danger" value="Cargar Imagen" />


    <canvas class="image-input__canvas"
      ref="canvas"
      v-bind:height="height"
      v-bind:width="width"
      v-bind:class="{ 'is-draggable': hoverIsDraggable }">
    </canvas>

  </div>


</script>




imprimir variable de base 64


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



