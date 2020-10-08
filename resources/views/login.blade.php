<!DOCTYPE html>
<html lang="es">
<head>
    <title>Capital Humano - Secretaría de Finanzas</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="/assets/template/css/app.css?v={{microtime(true)}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
    <!-- Global site tag (gtag.js) - Google Analytics -->
</head>
<body class="login-body">

@include('partials/header')
<main id="main-login" class="row">
    <div class="login-content">
        <div class="pane pane-basic login-box">
            <div class="pane-header">
                <h2>
                    Iniciar sesión
                </h2>
            </div>
            <div class="form-group">
                <label>Correo electrónico:</label>
                <input type="text" class="form-control" placeholder="Dirección de correo electrónico">
            </div>
            <div class="form-group">
                <label>Contraseña:</label>
                <input type="password" class="form-control" placeholder="Ingresa tu contraseña">
            </div>
            <div class="forgot">
                <a href="#" class="base-anchor">
                    Olvidé mi contraseña
                </a>
            </div>
            <div class="form-group">
                <button class="btn btn-main btn-group-justified">
                    Entrar <i class="fa fa-sign-in"></i>
                </button>
            </div>
        </div>
        <div class="aditional">
            <a href="#" class="">
                ¿Aún no tienes cuenta? <b>Regístrate</b>
            </a>
            <a href="#" class="">
                No recibí el correo de confirmación
            </a>
        </div>
        <div class="identity">
            <hr>
            <div class="item">
                <img src="{{url('/assets/template/images/Logo_CDMX.png')}}" width="170" alt="Secretaría de Obras de la CDMX">
                <img src="{{url('/assets/template/images/Logo_Dependencia.png')}}" width="170" alt="Secretaría de Finanzas de la CDMX">
            </div>
            <hr>
        </div>
    </div>
</main>

<div class="cover">
    <img src="{{url('/images/decoration.png')}}" alt="">
</div>

<script type="text/javascript" src="{{url('/assets/template/js/jquery.js')}}"></script>
<script type="text/javascript" src="{{url('/assets/template/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{url('/assets/template/js/ui-functions.js')}}"></script>

</body>
</html>
