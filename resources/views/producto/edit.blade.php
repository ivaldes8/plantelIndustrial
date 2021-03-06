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
                      {{$producto === "none" ? 'Crear Producto' : 'Editar Producto'}}
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{url('producto')}}" class="btn btn-success">Atrás</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
            @if($producto === "none")
                <form action="{{url('producto')}}" method="POST">
            @else
                <form action="{{url('producto/'.$producto->id)}}" method="POST">
                    @method('PUT')
            @endif
                    @csrf
                    <div class="form-group mb-3">
                        <label for="">Descripción:</label>
                        <input type="text" name="desc" class="form-control" value="{{ $producto !== 'none' ? $producto->desc : '' }}">
                        @if ($errors->has('desc'))
                            <span class="text-danger">{{ $errors->first('desc') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Actividades Industriales:</label>
                        <select name="actividades[]" multiple="multiple" class="form-select actSelect">
                            @foreach ($actividad as $item)
                                <option {{ $producto !== 'none' && $item->osde_id === 'checked' ? 'selected' : '' }} value="{{$item->id}}">{{$item->desc}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('actividades'))
                            <span class="text-danger">{{ $errors->first('actividades') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">CPCU:</label>
                        <select name="cpcu_id" class="form-select cpcuSelect">
                            @foreach ($cpcu as $item)
                                <option {{ $producto !== 'none' && $item->id == $producto->cpcu_id ? 'selected' : '' }} value="{{$item->id}}">{{$item->codigo}}/{{$item->desc}}</option>
                            @endforeach
                            <option value="">Ninguno</option>
                        </select>
                        @if ($errors->has('cpcu_id'))
                            <span class="text-danger">{{ $errors->first('cpcu_id') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">SACLAP:</label>
                        <select name="saclaps[]" multiple="multiple" class="form-select saclapSelect">
                            @foreach ($saclap as $item)
                                <option {{ $producto !== 'none' && $item->checked == 'checked' ? 'selected' : '' }} value="{{$item->id}}">{{$item->codigo}}/{{$item->desc}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('saclaps'))
                            <span class="text-danger">{{ $errors->first('saclaps') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">CNAE:</label>
                        <select name="nae_id" class="form-select cnaeSelect">
                            @foreach ($nae as $item)
                                <option {{ $producto !== 'none' && $item->id == $producto->nae_id ? 'selected' : '' }} value="{{$item->id}}">{{$item->codigo}}/{{$item->desc}}</option>
                            @endforeach
                            <option value="">Ninguno</option>
                        </select>
                        @if ($errors->has('nae_id'))
                            <span class="text-danger">{{ $errors->first('nae_id') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Familia de productos:</label>
                        <select name="familia_id" class="form-select cnaeSelect">
                            <option value="">Ninguna</option>
                            @foreach ($familia as $item)
                                <option {{ $producto !== 'none' && count($producto->familia) > 0 && $item->id == $producto->familia[0]->id ? 'selected' : '' }} value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach

                        </select>
                        @if ($errors->has('familia_id'))
                            <span class="text-danger">{{ $errors->first('familia_id') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3 d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">{{$producto === 'none' ? 'Crear' : 'Editar'}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.cpcuSelect').select2();
        });
        $(document).ready(function() {
            $('.saclapSelect').select2();
        });
        $(document).ready(function() {
            $('.cnaeSelect').select2();
        });
        $(document).ready(function() {
            $('.actSelect').select2();
        });
        $(document).ready(function() {
            $('.entSelect').select2();
        });
    </script>
@endsection

