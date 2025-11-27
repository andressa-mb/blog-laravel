@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @php
            $hasImages = $post->imagesPost()->exists();
            $thumb = $hasImages ? $post->imagesPost()->where('type', 3)->first() : null;
            $main = $hasImages ? $post->imagesPost()->where('type', 1)->first() : null;
            $commonImages = $hasImages ? $post->imagesPost()->where('type', 2)->get() : null ;
        @endphp

        @if (!$hasImages)
            <h3>Não há imagens salvas nesse post</h3>
        @else
            <h3>Imagens</h3>
        @endif

        @if ($thumb)
            <div class="col-md-12 my-5">
                <div class="card">
                    <div class="card-header">
                        Imagem da thumb
                    </div>
                    <div class="card-body text-center">
                        <img src="{{asset("storage/{$thumb->path}")}}" width="250" height="250">
                    </div>
                    <div class="card-footer">
                        <a href="{{route('change-image', [$post, $thumb])}}" type="button" class="btn btn-warning">Trocar imagem?</a>
                        <button type="button" class="btn btn-danger"
                            data-toggle="modal" data-target="#modal_confirma" data-route="{{route('delete-image', $thumb)}}">
                                Excluir
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if ($main)
            <div class="col-md-12 my-5">
                <div class="card">
                    <div class="card-header">
                        Imagem principal
                    </div>
                    <div class="card-body text-center">
                        <img src="{{asset("storage/{$main->path}")}}" width="250" height="250">
                    </div>
                    <div class="card-footer">
                        <a href="{{route('change-image', [$post, $main])}}" type="button" class="btn btn-warning">Trocar imagem?</a>
                        <button type="button" class="btn btn-danger"
                            data-toggle="modal" data-target="#modal_confirma" data-route="{{route('delete-image', $main)}}">
                                Excluir
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if ($commonImages)
            @foreach ($commonImages as $common)
                <div class="col-md my-5">
                    <div class="card">
                        <div class="card-header">
                            Imagens do post
                        </div>
                        <div class="card-body text-center">
                            <img src="{{asset("storage/{$common->path}")}}" width="250" height="250">
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-danger"
                            data-toggle="modal" data-target="#modal_confirma" data-route="{{route('delete-image', $common)}}">
                                Excluir
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        @component('layouts.components.modal-confirma', [
            'modal_id' => 'modal_confirma',
            'title' => 'Excluir imagem?',
            'classBtn' => 'btn btn-danger',
            'idBtn' => 'btn-confirm-delete',
        ])
            <p>Tem certeza que quer excluir a imagem selecionada?</p>

        @endcomponent

        @if (!$thumb || !$main || $commonImages )
            <div class="col-md-12 my-2">
                <a href="{{route('insert-images', $post)}}" class="btn btn-primary">Add imagens ao post</a>
            </div>
        @endif

        <div class="col-md-12 my-2">
            <a href="{{route('web.posts.index')}}" class="btn btn-success">
                Finalizar edição
            </a>
        </div>
</div>

@endsection

@push('scripts')
    <script>
        $('#modal_confirma').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget);
            let route = button.data('route');
            $(this).find('#btn-confirm-delete').attr('href', route);
        });
    </script>
@endpush
