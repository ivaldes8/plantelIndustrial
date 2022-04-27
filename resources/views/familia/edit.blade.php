@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-12">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6 mt-1 d-flex justify-content-start">
                        {{ $familia === 'none' ? 'Crear familia' : 'Editar familia' }}
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{ url('familia') }}" class="btn btn-success">Atrás</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if ($familia === 'none')
                    <form action="{{ url('familia') }}" method="POST">
                    @else
                        <form action="{{ url('familia/' . $familia->id) }}" method="POST">
                            @method('PUT')
                @endif
                @csrf
                <div class="form-group mb-3">
                    <label for="">Nombre:</label>
                    <input type="text" name="name" class="form-control"
                        value="{{ $familia !== 'none' ? $familia->name : '' }}">
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label for="">Productos:</label>
                    <select name="producto_id[]" multiple="multiple" class="form-select prodSelect">
                        @foreach ($producto as $item)
                            <option {{ $familia !== 'none' && $item->cpcu_id === 'checked' ? 'selected' : '' }}
                                value="{{ $item->id }}">{{ $item->desc }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('producto_id'))
                        <span class="text-danger">{{ $errors->first('producto_id') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3 d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit">{{ $familia === 'none' ? 'Crear' : 'Editar' }}</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.prodSelect').select2();
        });
    </script>
@endsection
