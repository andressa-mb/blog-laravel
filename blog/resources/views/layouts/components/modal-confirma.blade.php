<div class="modal fade" id="{{ $modal_id ?? ''}}" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="{{ $modal_id ?? ''}}">{{ $title }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                {{$slot}}
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Cancelar
                </button>
                <a href="#" id="{{ $idBtn ?? 'idBtn'}}" class="{{ $classBtn ?? 'btn btn-primary' }}" type="submit">
                    {{$btnText ?? 'Confirmar'}}
                </a>
            </div>
        </div>
    </div>

</div>
