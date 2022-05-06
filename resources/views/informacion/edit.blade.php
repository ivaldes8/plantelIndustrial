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
                      {{$informacion === "none" ? 'Crear Información' : 'Editar Información'}}
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{url('informacion')}}" class="btn btn-success">Atrás</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
            @if($informacion === "none")
                <form action="{{url('informacion')}}" method="POST">
            @else
                <form action="{{url('informacion/'.$informacion->id)}}" method="POST">
                    @method('PUT')
            @endif
                    @csrf
                    <div class="form-group mb-3">
                        <label for="">Producto:</label>
                        <select name="producto" class="form-select prodSelect">
                            @foreach ($productos as $item)
                                <option {{ $informacion !== 'none' && $item->id == $informacion->producto_id ? 'selected' : '' }} value="{{$item->id}}">{{$item->desc}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('producto'))
                            <span class="text-danger">{{ $errors->first('producto') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Entidad:</label>
                        <select name="entidad" class="form-select entSelect">
                            <option></option>
                            @foreach ($entidades as $item)
                                <option {{ $informacion !== 'none' && $item->id == $informacion->entidad_id ? 'selected' : '' }} value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('entidad'))
                            <span class="text-danger">{{ $errors->first('entidad') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Indicador:</label>
                        <select name="indicador" class="form-select indSelect">
                            @foreach ($indicadores as $item)
                                <option {{ $informacion !== 'none' && $item->id == $informacion->indicador_id ? 'selected' : '' }} value="{{$item->id}}">{{$item->desc}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('indicador'))
                            <span class="text-danger">{{ $errors->first('indicador') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Valor:</label>
                        <input type="number" name="valor" class="form-control" value="{{ $informacion !== 'none' ? $informacion->value : '' }}">
                        @if ($errors->has('valor'))
                            <span class="text-danger">{{ $errors->first('valor') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Unidad de medida:</label>
                        <select name="unidad" class="form-select unitSelect">
                            @foreach ($unidades as $item)
                                <option {{ $informacion !== 'none' && $item->id == $informacion->unidad_id ? 'selected' : '' }} value="{{$item->id}}">{{$item->desc}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('unidad'))
                            <span class="text-danger">{{ $errors->first('unidad') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Fecha:</label>
                        <input type="text" name="fecha" class="form-control date" value="{{ $informacion !== 'none' ? $informacion->date : '' }}">
                        @if ($errors->has('fecha'))
                            <span class="text-danger">{{ $errors->first('fecha') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3 d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">{{$informacion === 'none' ? 'Crear' : 'Editar'}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.prodSelect').select2();
        });
        $(document).ready(function() {
            $('.entSelect').select2({
                placeholder: "Entidades",
                allowClear: true
            });
        });
        $(document).ready(function() {
            $('.indSelect').select2();
        });
        $(document).ready(function() {
            $('.unitSelect').select2();
        });
        $('.date').datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: 'bottom'
        });
    </script>
@endsection

