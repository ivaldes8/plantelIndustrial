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
                      Filtrar Productos
                    </div>
                </div>
            </div>
            <form action="{{ url('filteringPlan') }}" method="get">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <span class="btn bi-currency-dollar" id="basic-addon1"></span>
                                <input type="float" name="planIni" class="form-control" id="planIni" placeholder="Valor mínimo">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <span class="btn bi-currency-dollar" id="basic-addon1"></span>
                                <input type="float" name="planEnd" class="form-control" id="planEnd" placeholder="Valor máximo">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <span class="btn bi-calendar-date" id="basic-addon1"></span>
                                <input type="number" name="yearIni" class="form-control" id="yearIni" placeholder="Año inicial">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <span class="btn bi-calendar-date" id="basic-addon1"></span>
                                <input type="number" name="yearEnd" class="form-control" id="yearEnd" placeholder="Año final">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-12 ">
                            <div class="form-group mb-3">
                                <span class="btn-sm bi-archive"  for="">Productos:</span>
                                <select name="productos[]" id="producto" multiple="multiple" class="form-select prodSelect">
                                    @foreach ($producto as $item)
                                        <option  value="{{$item->id}}">{{$item->desc}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class=" col-sm-6 col-12 ">
                            <div class="form-group mb-3">
                                <span class="btn-sm bi-shop"  for="">Entidades:</span>
                                <select name="entidades[]" id="entidad" multiple="multiple" class="form-select entSelect">
                                    @foreach ($entidad as $item)
                                        <option  value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class=" col-sm-6 col-12 ">
                            <div class="form-group mb-3">
                                <span class="btn-sm bi-graph-up-arrow"  for="">Indicadores:</span>
                                <select name="indicadores[]" id="indicador" multiple="multiple" class="form-select indSelect">
                                    @foreach ($indicador as $item)
                                        <option  value="{{$item->id}}">{{$item->desc}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer">
                    <div class="row justify-content-center">
                        <div class="col-12 d-flex justify-content-center">
                        <button id="clearFilters" class="btn btn-primary mx-1">Reiniciar Filtros</button>
                        <button class="btn btn-primary mx-1" type="submit">Buscar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card mt-2">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-primary table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Entidad</th>
                                <th>Producto</th>
                                <th>Indicador</th>
                                <th>Año</th>
                                <th>Plan</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if (count($plan) < 1)
                            <tr>
                                <td class="text-center" colspan="8">No se encontraron planes anuales</td>
                            </tr>
                        @else
                            @foreach ($plan as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->entidad->name}}</td>
                                    <td>{{$item->producto->desc}}</td>
                                    <td>{{$item->indicador->desc}}</td>
                                    <td>{{$item->year}}</td>
                                    <td>{{$item->plan}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <div class="d-flex">
                        {{ $plan->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.prodSelect').select2();
        });
        $(document).ready(function() {
            $('.indSelect').select2();
        });
        $(document).ready(function() {
            $('.entSelect').select2();
        });
        $(document).on('click', '#clearFilters', function(event) {
            event.preventDefault();
            $('.prodSelect').val(null).trigger('change');
            $('.entSelect').val(null).trigger('change');
            $('.indSelect').val(null).trigger('change');
            var planIni = document.getElementById('planIni').value=""
            var planEnd = document.getElementById('planEnd').value=""
            var yearIni = document.getElementById('yearIni').value=""
            var yearEnd = document.getElementById('yearEnd').value=""
        });
    </script>
@endsection
