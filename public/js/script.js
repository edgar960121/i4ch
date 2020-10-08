
(function() { 

	// Obtenenemos un intervalo regular(Tiempo) en la pamtalla
	window.requestAnimFrame = (function (callback) {
		return window.requestAnimationFrame ||
					window.webkitRequestAnimationFrame ||
					window.mozRequestAnimationFrame ||
					window.oRequestAnimationFrame ||
					window.msRequestAnimaitonFrame ||
					function (callback) {
					 	window.setTimeout(callback, 1000/60);
          
					};
	})();
	var canvas = document.getElementById("draw-canvas");
	var ctx = canvas.getContext("2d");
	
	// Mandamos llamar a los Elemetos interactivos de la Interfaz HTML
	var drawText = document.getElementById("draw-dataUrl");
	var drawImage = document.getElementById("draw-image");
	var clearBtn = document.getElementById("draw-clearBtn");
	var submitBtn = document.getElementById("draw-submitBtn");
	clearBtn.addEventListener("click", function (e) {
		// Definimos que pasa cuando el boton draw-clearBtn es pulsado
		clearCanvas();
		drawImage.setAttribute("src", "");
	}, false);
		// Definimos que pasa cuando el boton draw-submitBtn es pulsado
	submitBtn.addEventListener("click", function (e) {
	var dataUrl = canvas.toDataURL();
	drawText.innerHTML = dataUrl;
	drawImage.setAttribute("src", dataUrl);
	 }, false);

	// Activamos MouseEvent para nuestra pagina
	var drawing = false;
	var mousePos = { x:0, y:0 };
	var lastPos = mousePos;
	canvas.addEventListener("mousedown", function (e)
  {
    /*
      Mas alla de solo llamar a una funcion, usamos function (e){...}
      para mas versatilidad cuando ocurre un evento
    */
		var tint = document.getElementById("color");
		var punta = document.getElementById("puntero");
		console.log(e);
		drawing = true;
		lastPos = getMousePos(canvas, e);
	}, false);
	canvas.addEventListener("mouseup", function (e)
  {
		drawing = false;
	}, false);
	canvas.addEventListener("mousemove", function (e)
  {
		mousePos = getMousePos(canvas, e);
	}, false);

	// Activamos touchEvent para nuestra pagina
	canvas.addEventListener("touchstart", function (e) {
		mousePos = getTouchPos(canvas, e);
    console.log(mousePos);
    e.preventDefault(); 
		var touch = e.touches[0];
		var mouseEvent = new MouseEvent("mousedown", {
			clientX: touch.clientX,
			clientY: touch.clientY
		});
		canvas.dispatchEvent(mouseEvent);
	}, false);
	canvas.addEventListener("touchend", function (e) {
    e.preventDefault(); 
		var mouseEvent = new MouseEvent("mouseup", {});
		canvas.dispatchEvent(mouseEvent);
	}, false);
  canvas.addEventListener("touchleave", function (e) {
    // Realiza el mismo proceso que touchend en caso de que el dedo se deslice fuera del canvas
    e.preventDefault(); 
    var mouseEvent = new MouseEvent("mouseup", {});
    canvas.dispatchEvent(mouseEvent);
  }, false);
	canvas.addEventListener("touchmove", function (e) {
    e.preventDefault(); 
		var touch = e.touches[0];
		var mouseEvent = new MouseEvent("mousemove", {
			clientX: touch.clientX,
			clientY: touch.clientY
		});
		canvas.dispatchEvent(mouseEvent);
	}, false);


	function getMousePos(canvasDom, mouseEvent) {
		var rect = canvasDom.getBoundingClientRect();

		return {
			x: mouseEvent.clientX - rect.left,
			y: mouseEvent.clientY - rect.top
		};
	}


	function getTouchPos(canvasDom, touchEvent) {
		var rect = canvasDom.getBoundingClientRect();
    console.log(touchEvent);

		return {
			x: touchEvent.touches[0].clientX - rect.left,
			y: touchEvent.touches[0].clientY - rect.top
		};
	}


	function renderCanvas() {
		if (drawing) {
      var tint = document.getElementById("color");
      var punta = document.getElementById("puntero");
      ctx.strokeStyle = tint.value;
      ctx.beginPath();
			ctx.moveTo(lastPos.x, lastPos.y);
			ctx.lineTo(mousePos.x, mousePos.y);
      console.log(punta.value);
    	ctx.lineWidth = punta.value;
			ctx.stroke();
      ctx.closePath();
			lastPos = mousePos;
		}
	}

	function clearCanvas() {
		canvas.width = canvas.width;
	}


	(function drawLoop () {
		requestAnimFrame(drawLoop);
		renderCanvas();
	})();

})();