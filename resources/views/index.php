<!doctype html>
<html>
  <head>
  	<meta charset=utf-8> 
	    <link rel="stylesheet" type="text/css" href="css/style.css">

	    <link href="{{ asset('css/style.css')}}" rel="stylesheet"/>
		<script type="text/javascript" src="{{ asset('js/script.js') }}"></script>

  </head>
  <body>
	  <br><br>
	  	<div class="contenedor">
		<div class="row">
			  	<img src="img/cdmx.png" style="width: 800px;">
			<br>
			<div class="col-md-2">	
		 		<canvas id="draw-canvas" width="800" height="400">
		 			No tienes un buen navegador.
		 		</canvas>
		 	</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<br>
				<input type="button" class="button" id="draw-submitBtn" value="Guardar Imagen"></input>
				<input type="button" class="button" id="draw-clearBtn" value="Borrar"></input>
						<label>Color</label>
						<input type="color" id="color">
						<label>Tamaño Puntero</label>
						<input style="background-color: azure;" type="range" id="puntero" max="5">
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<textarea id="draw-dataUrl" class="form-control" rows="5" width="800" height="400">Para los que saben que es esto:</textarea>
			</div>
		</div>
		<br/>
		<div class="contenedor">
			<div class="col-md-12">
				<img id="draw-image" src="img/Logo.png" alt="Tu Imagen aparecera Aqui!"/>
			</div>
		</div>
	</div>
		  <script src="script/script.js"></script>		 
  </body>
</html>