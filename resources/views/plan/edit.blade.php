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
                      {{$plan === "none" ? 'Crear Plan' : 'Editar Plan'}}
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{url('plan')}}" class="btn btn-success">Atrás</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
            @if($plan === "none")
                <form action="{{url('plan')}}" method="POST">
            @else
                <form action="{{url('plan/'.$plan->id)}}" method="POST">
                    @method('PUT')
            @endif
                    @csrf

                    <div class="form-group mb-3">
                        <label for="">Entidad:</label>
                        <select name="entidad" class="form-select entidadSelect">
                            @foreach ($entidad as $item)
                                <option {{ $plan !== 'none' && $plan->entidad_id == $item->id ? 'selected' : '' }} value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('entidad'))
                            <span class="text-danger">{{ $errors->first('entidad') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Producto:</label>
                        <select name="producto" class="form-select productoSelect">
                            @foreach ($producto as $item)
                                <option {{ $plan !== 'none' && $plan->producto_id == $item->id ? 'selected' : '' }} value="{{$item->id}}">{{$item->desc}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('producto'))
                            <span class="text-danger">{{ $errors->first('producto') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Indicador:</label>
                        <select name="indicador" class="form-select indicadorSelect">
                            @foreach ($indicador as $item)
                                <option {{ $plan !== 'none' && $plan->indicador_id == $item->id ? 'selected' : '' }} value="{{$item->id}}">{{$item->desc}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('indicador'))
                            <span class="text-danger">{{ $errors->first('indicador') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Plan:</label>
                        <input type="float" name="plan" class="form-control" value="{{ $plan !== 'none' ? $plan->plan : '' }}">
                        @if ($errors->has('plan'))
                            <span class="text-danger">{{ $errors->first('plan') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Año:</label>
                        <input type="text" name="year" class="form-control" value="{{ $plan !== 'none' ? $plan->year : '' }}">
                        @if ($errors->has('year'))
                            <span class="text-danger">{{ $errors->first('year') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3 d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">{{$plan === 'none' ? 'Crear' : 'Editar'}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.entidadSelect').select2();
        });
        $(document).ready(function() {
            $('.productoSelect').select2();
        });
        $(document).ready(function() {
            $('.indicadorSelect').select2();
        });
    </script>
@endsection

