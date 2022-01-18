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
                      {{$indicador === "none" ? 'Crear Indicador del Producto' : 'Editar Indicador del Producto'}}
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{ URL::previous() }}" class="btn btn-success">Atrás</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
            @if($indicador === "none")
                <form action="{{url('indicador-producto/create/'.$producto->id)}}" method="POST">
            @else
                <form action="{{url('indicador-producto/'.$indicador->id.'/update/'.$producto->id)}}" method="POST">
                    @method('PUT')
            @endif
                    @csrf
                    <div class="form-group mb-3">
                        <label for="">Indicadores:</label>
                        <select name="indicador" class="form-select indSelect">
                            @foreach ($indicadores as $item)
                                <option {{$indicador !== "none" && $item->id === $indicador->indicador_id ? 'selected' : '' }} value="{{$item->id}}">{{$item->desc}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('indicador'))
                            <span class="text-danger">{{ $errors->first('indicador') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Valor:</label>
                        <input type="number" name="value" class="form-control" value="{{ $indicador !== 'none' ? $indicador->value : '' }}">
                        @if ($errors->has('value'))
                            <span class="text-danger">{{ $errors->first('value') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label>Fecha de firma:</label>
                        <div class='input-group'>
                            <input type='text' class="form-control date"  name="date" value="{{ $indicador !== 'none' ? $indicador->date : '' }}"/>
                            <span  class="btn bi-calendar2-date"></span>
                        </div>
                        @if ($errors->has('date'))
                            <span class="text-danger">{{ $errors->first('date') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3 d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">{{$indicador === 'none' ? 'Crear' : 'Editar'}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $('.date').datepicker({
            format: 'yyyy-mm-dd'
        });
        $(document).ready(function() {
            $('.indSelect').select2();
        });
    </script>
@endsection

