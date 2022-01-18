<form action="{{ url('indicador-producto/delete/' .$indicador->id) }}" method="post">
    <div class="modal-body">
        @csrf
        @method('DELETE')
        <h5 class="text-center">Seguro que desea eliminar esta relación ?</h5>
        <h1 class="text-center">{{$indicador->indicador->desc}}-{{$indicador->value}}-{{$indicador->date}}</h1>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-danger">Si, Eliminar esta relación</button>
    </div>
</form>
