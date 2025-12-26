@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="mx-2 border border-dark rounded-pill">
            <h4 class="text-center p-2">Página de {{$blogger->name}}</h4>
            <div class="text-center">
                @foreach ($blogger->roles as $role)
                    <p class="badge badge-primary p-2">{{$role->name}}</p>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="row d-flex justify-content-around">
    @if ($blogger->posts()->exists())
        <div class="col-md-12">
            <h5 class="m-5">Total de posts: {{$blogger->posts()->count()}}</h5>
        </div>
        @foreach ($blogger->posts()->orderBy('created_at', 'desc')->get() as $post)
            @php
                $thumb = $post->images()->where('type', 3)->first();
            @endphp

            <div class="card mx-3 my-3" style="width: 540px;">
                <div class="row no-gutters">
                    @if($thumb)
                        <div class="col-md-4 d-flex align-items-center justify-content-center">
                            <img src="{{asset("storage/{$thumb->path}")}}" width="{{$thumb->width}}" height="{{$thumb->height}}">
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
    @else
        <div class="col-md-12">
            <h5 class="m-5">Não há posts deste usuário ainda.</h5>
        </div>
    @endif
</div>
@endsection
