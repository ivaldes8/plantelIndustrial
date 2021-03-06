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
                        Productos
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <a href="{{ url('producto-file-import') }}" class="btn btn-primary">Importar Productos</a>
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <a href="{{ url('producto/create') }}" class="btn btn-primary">Crear Producto</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-primary table-bordered table-striped">
                        <thead>
                            <tr style="font-size: 90%;">
                                <th style="width: 20px;">ID</th>
                                <th style="width: 200px;">Descripción</th>
                                <th style="width: 100px;">CPCU</th>
                                <th style="width: 100px;">SACLAP</th>
                                <th style="width: 100px;">CNAE</th>
                                <th style="width: 200px;">Actividades Industriales</th>
                                <th style="width: 100px;">Familia</th>
                                <th style="width: 20px;">Editar</th>
                                <th style="width: 20px;">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($producto) < 1)
                                <tr>
                                    <td class="text-center" colspan="10">No se encontraron productos</td>
                                </tr>
                            @else
                                @foreach ($producto as $item)
                                    <tr style="font-size: 90%;">
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->desc }}</td>
                                        <td>{{ $item->cpcu ? $item->cpcu->codigo : '---' }}</td>
                                        <td>
                                            @if (count($item->saclaps) > 0)
                                                @foreach ($item->saclaps as $saclap)
                                                    / {{ $saclap->codigo }}
                                                @endforeach
                                            @else
                                                ---
                                            @endif
                                        </td>
                                        {{-- <td>{{$item->saclap ? $item->saclap->codigo : '---'}}</td> --}}
                                        <td>{{ $item->cnae ? $item->cnae->codigo : '---' }}</td>
                                        <td>
                                            @if (count($item->actividades) > 0)
                                                @foreach ($item->actividades as $actividad)
                                                    / {{ $actividad->desc }}
                                                @endforeach
                                            @else
                                                ---
                                            @endif
                                        </td>
                                        <td>
                                            @if (count($item->familia) > 0)
                                                @foreach ($item->familia as $fam)
                                                    / {{ $fam->name }}
                                                @endforeach
                                            @else
                                                ---
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('producto/' . $item->id . '/edit') }}"
                                                class="btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                                        </td>
                                        <td>
                                            <button class="btn-sm btn-danger" data-toggle="modal" id="smallButton"
                                                data-target="#smallModal"
                                                data-attr="{{ url('producto/delete', $item->id) }}"
                                                title="Delete Project">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>
                    <div class="d-flex">
                        {{ $producto->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- small modal -->
    <div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Producto</h5>
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
                url: href,
                beforeSend: function() {
                    $('#loader').show();
                },
                // return the result
                success: function(result) {
                    $('#smallModal').modal("show");
                    $('#smallBody').html(result).show();
                },
                complete: function() {
                    $('#loader').hide();
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    $('#loader').hide();
                },
                timeout: 8000
            })
        });
    </script>
@endsection
