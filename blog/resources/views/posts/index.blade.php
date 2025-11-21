@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <a href="{{route('web.posts.create')}}" type="button" class="btn btn-success">Criar Post</a>
            </div>
        </div>

        <div class="row my-4">
            <div class="col-md-12 d-flex justify-content-end">
                {{$posts->links()}}
            </div>

            <div class="row d-flex justify-content-around">
                @foreach ($posts as $post)
                    @php
                        $thumb = $post->imagesPost()->where('type', 3)->first();
                    @endphp

                    <div class="card mx-3 my-3" style="max-width: 540px;">
                        <div class="row no-gutters">
                            @if($thumb)
                                <div class="col-md-4 d-flex align-items-center justify-content-center">
                                    <img src="{{asset("storage/{$thumb->url}")}}" width="{{$thumb->width}}" height="{{$thumb->height}}">
                                </div>
                            @else
                                <div class="col-md-4 d-flex align-items-center justify-content-center">
                                    <img src="{{asset("storage/default/no-image.jpg")}}" width="100" height="100" alt="Sem imagem">
                                </div>
                            @endif
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title text-capitalize">{{$post->title}}</h5>
                                    <p class="card-text text-truncate">{{$post->content}}</p>
                                    <p class="card-text text-right">
                                        <small class="text-muted">Inserido por: {{$post->author->name}}</small> <br>
                                        <small class="text-muted">Em: {{$post->created_at->format('d/m/Y')}}</small>
                                    </p>
                                    <a href="{{route('web.posts.show', $post)}}" class="btn btn-sm btn-primary">Abrir post</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-12 d-flex justify-content-end">
                {{$posts->links()}}
            </div>
        </div>
    </div>
</div>
@endsection
