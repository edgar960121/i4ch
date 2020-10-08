@extends('templates.master')
@section('titulo','CDMX | Plataforma')

@section('head')
    <link rel="stylesheet" href="{!! asset('assets/css/font-awesome/css/font-awesome.min.css') !!}">
@endsection

@section('nav')
	
@endsection

@section('nav2')
    @include('templates.nav2',['nav2'=> [ ['nombre'=>'&laquo; Página principal','href'=> url('/principal')],
    									  ['nombre'=>'Mis recibos','href'=> url('/recibos/personal')],
    									  ['nombre'=>'Mis constancias','href'=> url('/recibos/comprobantes')]
                                        ]
                              ]
            )
@endsection

@section('container')  
    <div class="divGeneral container">
		<h2><strong>Administrador de recibos de pago</strong></h2>
		<form action="{{ url('/recibos/buscaRecibos') }}" method="post">
			<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
			<div class="form-group col-md-7">
				<label for="rfc">RFC</label>
				<input type="text" class="form-control" name="rfc" placeholder="Ingrese el RFC">
			</div>
			<div class="form-group col-md-7">
				<label for="curp">CURP</label>
				<input type="text" class="form-control" name="curp" placeholder="Ingrese el CURP">
			</div>
			<div class="form-group col-md-7">
				<label for="curp">Año</label>
				<select class="form-control" name="ann">
					@for($i=date('Y');$i>=2016;$i--)
					<option value="{{ $i }}">{{ $i }}</option>
					@endfor
				</select>
			</div>
			<div class="form-group col-md-7">
				<button type="submit" class="btn btn-primary">Consultar</button>
			</div>
			
		</form>
    </div>
@endsection

@section('js')
    
@endsection

@section('customjs')
    
@endsection