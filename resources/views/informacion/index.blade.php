@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-12">
            @if (session('status'))
                <div class="alert alert-success">{{session('status')}}</div>
            @endif
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6 mt-1 d-flex justify-content-start">
                       Información
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <a href="{{url('informacion-file-import')}}" class="btn btn-primary">Importar Información</a>
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <a href="{{url('informacion/create')}}" class="btn btn-primary disabled">Crear Información</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ url('informacion') }}" method="get">
                    <div class="row">
                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <select name="producto" class="form-control form-control-sm productoSelect">
                                    <option></option>
                                    @foreach ($productos as $item)
                                        <option value="{{ $item->id }}">{{ $item->desc }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <select name="cpcu" class="form-control form-control-sm cpcuSelect">
                                    <option></option>
                                    @foreach ($cpcus as $item)
                                        <option value="{{ $item->id }}">{{ $item->codigo }} {{ $item->desc }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <select name="saclap" class="form-control form-control-sm saclapSelect">
                                    <option></option>
                                    @foreach ($saclaps as $item)
                                        <option value="{{ $item->id }}">{{ $item->codigo }} {{ $item->desc }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-3 d-flex justify-content-end">
                            <button class="btn btn-sm btn-primary mx-1" type="submit">Buscar</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <select name="familia" class="form-control form-control-sm familiaSelect">
                                    <option></option>
                                    @foreach ($familias as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <select name="entidad" class="form-control form-control-sm entidadSelect">
                                    <option></option>
                                    @foreach ($entidades as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <select name="nae" class="form-control form-control-sm naeSelect">
                                    <option></option>
                                    @foreach ($naes as $item)
                                        <option value="{{ $item->id }}">{{ $item->codigo }} {{ $item->desc }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-2 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <select name="unidad" class="form-control form-control-sm unidadSelect">
                                    <option></option>
                                    @foreach ($unidades as $item)
                                        <option value="{{ $item->id }}">{{ $item->desc }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <select name="actividad" class="form-control form-control-sm actSelect">
                                    <option></option>
                                    @foreach ($actividades as $item)
                                        <option value="{{ $item->id }}">{{ $item->desc }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <select name="indicador" class="form-control form-control-sm indicadorSelect">
                                    <option></option>
                                    @foreach ($indicadores as $item)
                                        <option value="{{ $item->id }}">{{ $item->desc }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <input type="number" name="valorIni" class="form-control form-control-sm" id="valor" placeholder="Valor desde">
                            </div>
                        </div>
                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <input type="number" name="valorEnd" class="form-control form-control-sm" id="valor" placeholder="Valor hasta">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <input type="text" name="fechaIni" class="form-control form-control-sm startDate" id="fechaIni" placeholder="Desde ...">
                            </div>
                        </div>
                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <input type="text" name="fechaEnd" class="form-control form-control-sm endDate" id="fechaEnd" placeholder="Hasta ...">
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="table-responsive">
                    <table class="table table-primary table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Producto</th>
                                <th>Entidad</th>
                                <th>Indicador</th>
                                <th>Valor</th>
                                <th>Unidad de Medida</th>
                                <th>Fecha</th>
                                <th>Editar</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if (count($informacion) < 1)
                            <tr>
                                <td class="text-center" colspan="9">No se encontró información</td>
                            </tr>
                        @else
                            @foreach ($informacion as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->producto ? $item->producto->desc : '---'}}</td>
                                    <td>{{$item->entidad ? $item->entidad->name : '---'}}</td>
                                    <td>{{$item->indicador ? $item->indicador->desc : '---'}}</td>
                                    <td>{{$item->value}}</td>
                                    <td>{{$item->unidad->desc}}</td>
                                    <td>{{$item->date}}</td>
                                    <td>
                                        <a href="{{url('informacion/'.$item->id.'/edit')}}" class="btn-sm btn-primary">Editar</a>
                                    </td>
                                    <td>
                                        <button class="btn-sm btn-danger" data-toggle="modal" id="smallButton" data-target="#smallModal" data-attr="{{ url('informacion/delete', $item->id) }}" title="Delete Project">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        </tbody>
                    </table>
                    <div class="d-flex">
                        {{ $informacion->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- small modal -->
    <div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Información</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="smallBody">
                    <div>
                        <!-- the result to be displayed apply here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).on('click', '#smallButton', function(event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            $.ajax({
                url: href
                , beforeSend: function() {
                    $('#loader').show();
                },
                // return the result
                success: function(result) {
                    $('#smallModal').modal("show");
                    $('#smallBody').html(result).show();
                }
                , complete: function() {
                    $('#loader').hide();
                }
                , error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    $('#loader').hide();
                }
                , timeout: 8000
            })
        });
        $(document).ready(function() {
            $('.productoSelect').select2({
                placeholder: "Productos",
                allowClear: true
            });
            $('.cpcuSelect').select2({
                placeholder: "Código CPCU",
                allowClear: true
            });
            $('.saclapSelect').select2({
                placeholder: "Código SACLAP",
                allowClear: true
            });
            $('.familiaSelect').select2({
                placeholder: "Familia",
                allowClear: true
            });
            $('.entidadSelect').select2({
                placeholder: "Entidad",
                allowClear: true
            });
            $('.naeSelect').select2({
                placeholder: "Código NAE",
                allowClear: true
            });
            $('.unidadSelect').select2({
                placeholder: "Unidad de medida",
                allowClear: true
            });
            $('.actSelect').select2({
                placeholder: "Actividades Industriales",
                allowClear: true
            });
            $('.indicadorSelect').select2({
                placeholder: "Indicadores",
                allowClear: true
            });
            $('.startDate').datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                autoclose: true,
                orientation: 'bottom'
            });
            $('.endDate').datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                autoclose: true,
                orientation: 'bottom'
            });
        });
    </script>
@endsection
