@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        @component('layouts.components.page-links')
            <a href="{{route('web.posts.create')}}" type="button" class="btn btn-success">{{__('messages.criar-post')}}</a>
        @endcomponent

        @component('layouts.components.page-links', ['class' => 'col-md-12 d-flex justify-content-end my-3'])
            {{$posts->links()}}
        @endcomponent

        <div class="row d-flex justify-content-around">
            @foreach ($posts as $post)
                @php($thumb = $post->images()->getThumbImgPost()->first())

                <div class="card mx-3 my-3" style="width: 540px;">
                    <div class="row no-gutters">
                        @if($thumb)
                            <div class="col-md-4 d-flex align-items-center justify-content-center">
                                <img src="{{asset("storage/{$thumb->path}")}}" width="{{$thumb->width}}" height="{{$thumb->height}}">
                            </div>
                        @else
                            <div class="col-md-4 d-flex align-items-center justify-content-center">
                                <img src="{{asset("storage/default/no-image.jpg")}}" width="100" height="100" alt="{{__('messages.sem_imagem')}}">
                            </div>
                        @endif
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title text-capitalize">{{$post->title}}</h5>
                                <p class="card-text text-truncate">{{$post->content}}</p>
                                <p class="card-text text-right">
                                    <small class="text-muted">{{__('messages.inserido_por')}} {{$post->author->name}}</small> <br>
                                    <small class="text-muted">{{__('messages.em')}} {{$post->created_at->format('d/m/Y')}}</small>
                                </p>
                                <a href="{{route('web.posts.show', $post)}}" class="btn btn-sm btn-primary">{{__('messages.abrir_post')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @component('layouts.components.page-links', ['class' => 'col-md-12 d-flex justify-content-end my-3'])
            {{$posts->links()}}
        @endcomponent
    </div>
</div>
@endsection
