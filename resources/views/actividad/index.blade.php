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
                       Actividad Industrial
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{url('actividad/create')}}" class="btn btn-primary">Crear Actividad Industrial</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-primary table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Descripción</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if (count($actividad) < 1)
                            <tr>
                                <td class="text-center" colspan="7">No se encontraron actividades industriales</td>
                            </tr>
                        @else
                            @foreach ($actividad as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->desc}}</td>
                                    <td>
                                        <a href="{{url('actividad/'.$item->id.'/edit')}}" class="btn-sm btn-primary">Editar</a>
                                    </td>
                                    <td>
                                        <button class="btn-sm btn-danger" data-toggle="modal" id="smallButton" data-target="#smallModal" data-attr="{{ url('actividad/delete', $item->id) }}" title="Delete Project">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <div class="d-flex">
                        {{ $actividad->links() }}
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
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Actividad Industrial</h5>
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
    </script>
@endsection
