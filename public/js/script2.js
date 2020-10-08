var sharedData = {
  imageData: '',
  updateImageData: function (newData) {
    this.imageData = newData;
  } };


Vue.component('image-uploader', {
  template: '#image-uploader-template',
  props: ['id', 'width', 'height'],

  // Debe ser una función en la definición de componentes
  data: function () {
    return {
      isImageLoaded: false,
      hoverIsDraggable: false,
      // Image
      ctx: null, canvas: null,
      img: null,
      // Propiedades
      scaleSteps: 0,
      imageX: 0, imageY: 0,
      scaledImageWidth: 0, scaledImageHeight: 0,
      imageWidth: 0, imageHeight: 0, imageRight: 0, imageBottom: 0,
      // Estado
      draggingImage: false,
      // Ratón
      startX: 0, startY: 0,
      mouseX: 0, mouseY: 0,
      sharedData: window.sharedData };

  },
  computed: {
    containerStyles: function () {
      return {
        width: this.width,
        height: this.height };

    } },

  mounted: function () {
    this.$on('get-image-base64', function () {
      console.log("ON'ING");
      this.updateTemplateImage();
    });

    this.canvas = this.$refs.canvas;
    this.ctx = this.canvas.getContext("2d");
    this.img = document.createElement("img");
  },
  methods: {
    toBase64: function ()
    {
      var imageData = this.canvas.toDataURL("image/png");
      imageData.replace('data:image/png;base64,', '');
      this.sharedData.updateImageData(imageData);
    },
    draw: function (withBorders)
    {
      this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

      var scaleFactor = 1 - this.scaleSteps * .1;
      this.scaledImageWidth = this.img.width * scaleFactor;
      this.scaledImageHeight = this.scaledImageWidth * (this.img.height / this.img.width);

      this.ctx.drawImage(this.img, 0, 0, this.img.width, this.img.height, this.imageX, this.imageY, this.scaledImageWidth, this.scaledImageHeight);

      this.imageRight = this.imageX + this.scaledImageWidth;
      this.imageBottom = this.imageY + this.scaledImageHeight;

      // Opcionalmente dibuje un cuadro alrededor de la imagen (indica "seleccionado")
      if (withBorders) {
        this.ctx.beginPath();
        this.ctx.moveTo(this.imageX, this.imageY);
        this.ctx.lineTo(this.imageRight, this.imageY);
        this.ctx.lineTo(this.imageRight, this.imageBottom);
        this.ctx.lineTo(this.imageX, this.imageBottom);
        this.ctx.closePath();
        this.ctx.stroke();
      }
    },
    resetInput: function () {
      // limpiar el lienzo
      this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
      // Restablecer estado
      this.$refs.form.reset();
      this.isImageLoaded = false;
    },
    scaleUp: function () {
      this.scaleSteps--;
      this.draw(false);
    },
    scaleDown: function () {
      this.scaleSteps++;
      this.draw(false);
    },
    getMousePos: function (evt) {
      var rect = this.canvas.getBoundingClientRect(), 
      scaleX = this.canvas.width / rect.width, 
      scaleY = this.canvas.height / rect.height; 

      return {
        x: (evt.clientX - rect.left) * scaleX, // escalar las coordenadas del mouse después de que tienen
        y: (evt.clientY - rect.top) * scaleY // ha sido ajustado para ser relativo al elemento
      };
    },
    isImageHit: function (x, y) {
      return x > this.imageX && x < this.imageX + this.imageWidth && y > this.imageY && y < this.imageY + this.imageHeight;
    },
    triggerInput: function (event)
    {
      event.preventDefault();
      this.$refs.fileInput.click();
    },
    previewThumbnail: function (event)
    {
      var vm = this;
      var input = event.target;

      if (input.files && input.files[0])
      {
        var reader = new FileReader();

        // Establecer como fuente
        reader.onload = function (e) {
          vm.img.src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);

        vm.img.onload = function ()
        {
 
          vm.ctx.drawImage(vm.img, 0, 0);

          vm.imageWidth = vm.img.width;
          vm.imageHeight = vm.img.height;
          vm.imageRight = vm.imageX + vm.imageWidth;
          vm.imageBottom = vm.imageY + vm.imageHeight;

       
          vm.draw(false);

    
          vm.isImageLoaded = true;
        };
      }

      function handleMouseDown(e) {
        var pos = vm.getMousePos(e);
        vm.startX = pos.x;
        vm.startY = pos.y;
        vm.draggingImage = vm.hoverIsDraggable;
      }

      function handleMouseUp(e) {
        vm.draggingImage = false;
        vm.draw(false);
      }

      function handleMouseOut(e) {
        handleMouseUp(e);
      }

      function handleMouseMove(e)
      {

        var pos = vm.getMousePos(e);
        vm.hoverIsDraggable = vm.isImageHit(pos.x, pos.y);

        if (vm.draggingImage)
        {
         
          vm.mouseX = pos.x;
          vm.mouseY = pos.y;

          // mueve la imagen por la cantidad de la última resistencia
          var dx = vm.mouseX - vm.startX;
          var dy = vm.mouseY - vm.startY;

          // Bloquear imagen a vista de lienzo
          var collidedOnLeft = vm.imageX > 0 && dx > 0;
          var collidedOnRight = vm.imageRight < vm.canvas.width && dx < 0;
          var collidedOnTop = vm.imageY > 0 && dy > 0;
          var collidedOnBottom = vm.imageBottom < vm.canvas.height && dy < 0;

          if (collidedOnLeft) {
            vm.imageX = 0;
            vm.imageRight = vm.scaledImageWidth;
          } else
          if (collidedOnRight) {
            vm.imageX = vm.canvas.width - vm.scaledImageWidth;
            vm.imageRight = vm.canvas.width;
          } else {
            vm.imageX += dx;
            vm.imageRight += dx;
          }

          if (collidedOnTop) {
            vm.imageY = 0;
            vm.imageBottom = vm.scaledImageHeight;
          } else
          if (collidedOnBottom) {
            vm.imageY = vm.canvas.height - vm.scaledImageHeight;
            vm.imageBottom = vm.canvas.height;
          } else {
            vm.imageY += dy;
            vm.imageBottom += dy;
          }

          // Restablece startXY para la próxima vez
          vm.startX = vm.mouseX;
          vm.startY = vm.mouseY;

          // Redibujar la imagen con borde
          vm.draw(true);
        }
      } 


      vm.canvas.addEventListener('mousedown', handleMouseDown, false);
      vm.canvas.addEventListener('mousemove', handleMouseMove, false);
      vm.canvas.addEventListener('mouseup', handleMouseUp, false);
      vm.canvas.addEventListener('mouseout', handleMouseOut, false);
    } } });

var app = new Vue({
  el: '#app',
  data: {
    sharedData: window.sharedData },
  methods: {} });
