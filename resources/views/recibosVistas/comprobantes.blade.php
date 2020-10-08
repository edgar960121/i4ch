@extends('templates.master')
@section('titulo','CDMX | Recibos de pago')

@section('head')
    <link rel="stylesheet" href="{!! asset('assets/css/font-awesome/css/font-awesome.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/css/bootstrap/dataTables.bootstrap.min.css') !!}">
@endsection

@section('nav')
    {{-- <li><a class="navButton" href="{{ url('/logout') }}">Cerrar sesión</a></li> --}}
@endsection

@section('nav2')
    @if(\Session::has('rfcUser'))
        @include('templates.nav2',['nav2'=> [ 
                                                ['nombre'=>'&laquo; Administrador de recibos','href'=> url('/recibos/principal')],
                                                ['nombre'=>'Mis recibos','href'=> url('/recibos/principal')],
                                                ['nombre'=>'Mis constancias','href'=> url('/recibos/comprobantes')]
                                            ]
                                  ]
                )
    @else
        @include('templates.nav2',['nav2'=> [ ['nombre'=>'&laquo; Página principal','href'=> url('/principal')],
                                              ['nombre'=>'Mis recibos','href'=> url('/recibos/principal')],
                                              ['nombre'=>'Mis constancias','href'=> url('/recibos/comprobantes')]
                                            ]
                                  ]
                )
    @endif
@endsection

@section('container')  
    <div class="divIzquierdo">
        <div class="sidebar">
            <div class="titulo">Años</div>
            <div class="elementos">
                <ul>
                    @for($i=date('Y');$i>=2017;$i--)
                        <li class="{{ ($Comprobantes['anio']==$i)?'active':'' }}">
                            <a class="enviaFase" href="{{ url('/recibos/comprobantes?a='.$i.'&token='.$token) }}">
                                <div>
                                    <label class="sideBarItem">2016</label>
                                </div>
                            </a>
                        </li>
                    @endfor
                </ul>
            </div>
        </div>
    </div>
    <div class="divDerecho">
        <h3 style="margin-top: 0px; margin-bottom: 21px;">{{ $Comprobantes['nombreReceptor']}}</h3>
        <label style="float: left;display:block; width: 40px;">RFC</label>
        <label style="float: left;font-weight: normal; margin-right: 50px;">{{ strtoupper($Comprobantes['rfcReceptor']) }}</label>
        <label style="float: left; display:block; width: 50px;">CURP</label>
        <label style="float: left;font-weight: normal;">{{ strtoupper($Comprobantes['CURP']) }}</label><br><br>
        <h4>Constancia de sueldos, salarios, conceptos asimilados, credito al salario y subsidio para el empleo.</h4><br>
        <div class="col-md-8"><label>Descarga pdf</label></div>
        <div class="col-md-4"></div>
        <form target="_blank" action="{{ url('/constancia/pdf') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="anio" value="2016">
            <input type="image" height="30" src="{!! asset('/assets/imagenes/pdf.png') !!}">
        </form>
   </div> 
@endsection

@section('js')
    <script src="{!! asset('assets/js/bootstrap/jquery.dataTables.min.js') !!}"></script>
    <script src="{!! asset('assets/js/bootstrap/dataTables.bootstrap.min.js') !!}"></script>
    <script src="{!! asset('assets/js/jquery.lockfixed.js') !!}"></script>
@endsection

@section('customjs')
    <script type="text/javascript">
        $(document).ready(function(){
            $.lockfixed(".sidebar",{offset: {top: 100, bottom: 65}});
        });

        $('#tablaDetalle').DataTable({
          "order": false,
          "columns": [{ "width":"30%"},{ "width":"30%"},{ "width":"20%"},{ "width":"20%"}],
          "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "Todos"]],
          "language": {
            "lengthMenu": "Mostrar: _MENU_ por página",
            "zeroRecords": "No existen recibos",
            "info": "Página _PAGE_ de _PAGES_",
            "infoEmpty": "No existen recibos",
            "infoFiltered": "(Filtrados de _MAX_ totales)",
            "paginate": {
                "first":      "Primero",
                "last":       "Último",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            "search": "Buscar"
          }

        });
    </script>
@endsection