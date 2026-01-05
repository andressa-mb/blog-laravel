@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @php
            $hasImages = $post->images()->exists();
            $thumb = $hasImages ? $post->images()->getThumbImgPost()->first() : null;
            $main = $hasImages ? $post->images()->getMainImgPost()->first() : null;
            $commonImages = $hasImages ? $post->images()->getCommonImgPost()->get() : null ;
        @endphp

        @if (!$hasImages)
            <h3>{{__('text.sem_imagens')}}</h3>
        @else
            <h3>{{__('messages.imagens')}}</h3>
        @endif

        @if ($thumb)
            <div class="col-md-12 my-5">
                <div class="card">
                    <div class="card-header">
                        {{__('messages.imagens_tamanho', ['tamanho' => __('messages.thumb')] )}}
                    </div>
                    <div class="card-body text-center">
                        <img src="{{asset("storage/{$thumb->path}")}}" width="250" height="250">
                    </div>
                    <div class="card-footer">
                        <a href="{{route('change-image', [$post, $thumb])}}" type="button" class="btn btn-warning">{{__('messages.trocar_imagem')}}?</a>
                        <button type="button" class="btn btn-danger"
                            data-toggle="modal" data-target="#modal_confirma" data-route="{{route('delete-image', $thumb)}}">
                                {{__('messages.excluir')}}
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if ($main)
            <div class="col-md-12 my-5">
                <div class="card">
                    <div class="card-header">
                        {{__('messages.imagens_tamanho', ['tamanho' => __('messages.thumb')] )}}
                    </div>
                    <div class="card-body text-center">
                        <img src="{{asset("storage/{$main->path}")}}" width="250" height="250">
                    </div>
                    <div class="card-footer">
                        <a href="{{route('change-image', [$post, $main])}}" type="button" class="btn btn-warning">{{__('messages.trocar_imagem')}}?</a>
                        <button type="button" class="btn btn-danger"
                            data-toggle="modal" data-target="#modal_confirma" data-route="{{route('delete-image', $main)}}">
                                {{__('messages.excluir')}}
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
                            {{__('messages.imagens_tamanho', ['tamanho' => __('messages.post')] )}}
                        </div>
                        <div class="card-body text-center">
                            <img src="{{asset("storage/{$common->path}")}}" width="250" height="250">
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-danger"
                            data-toggle="modal" data-target="#modal_confirma" data-route="{{route('delete-image', $common)}}">
                                {{__('messages.excluir')}}
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        @component('layouts.components.modal-confirma', [
            'modal_id' => 'modal_confirma',
            'title' => __('messages.excluir_imagem').'?',
            'classBtn' => 'btn btn-danger',
            'idBtn' => 'btn-confirm-delete',
        ])
            <p>{{__('text.confirma_exclusao_imagem')}}</p>

        @endcomponent

        @if (!$thumb || !$main || $commonImages )
            <div class="col-md-12 my-2">
                <a href="{{route('insert-images', $post)}}" class="btn btn-primary">{{__('text.add_images_post')}}</a>
            </div>
        @endif

        <div class="col-md-12 my-2">
            <a href="{{route('web.posts.index')}}" class="btn btn-success">
                {{__('messages.finalizar')}}
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
