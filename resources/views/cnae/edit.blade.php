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
                      {{$cnae === "none" ? 'Crear cnae' : 'Editar cnae'}}
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{url('cnae')}}" class="btn btn-success">Atrás</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
            @if($cnae === "none")
                <form action="{{url('cnae')}}" method="POST">
            @else
                <form action="{{url('cnae/'.$cnae->id)}}" method="POST">
                    @method('PUT')
            @endif
                    @csrf
                    <div class="form-group mb-3">
                        <label for="">Código:</label>
                        <input type="text" name="codigo" class="form-control" value="{{ $cnae !== 'none' ? $cnae->codigo : '' }}">
                        @if ($errors->has('codigo'))
                            <span class="text-danger">{{ $errors->first('codigo') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Descripción:</label>
                        <input type="text" name="desc" class="form-control" value="{{ $cnae !== 'none' ? $cnae->desc : '' }}">
                        @if ($errors->has('desc'))
                            <span class="text-danger">{{ $errors->first('desc') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3 d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">{{$cnae === 'none' ? 'Crear' : 'Editar'}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

