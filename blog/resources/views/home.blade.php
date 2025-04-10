@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        {{$posts->links()}}
    </div>
    <div class="row m-4">
        @foreach($posts as $post)
        @php
        $image = $post->getThumb();
        @endphp
        <div class="card d-flex flex-row justify-content-around col-md-3 m-2" style="width: 10rem;">
            <div class="card-body text-center">
                <h5 class="card-title">{{$post->title}}</h5>
                @if(Auth::check())
                <a href="{{route('posts.show', $post)}}" class="btn btn-primary">Abrir post</a>
                @else
                <a href="{{route('home.show', $post)}}" class="btn btn-primary">Abrir post</a>
                @endif
                @if(!is_null($image))
                <img src="{{asset("storage/{$image->path}")}}" width="{{$image->width}}" height="{{$image->height}}" alt="Imagem teste">
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <div>
        {{$posts->links()}}
    </div>
</div>
@endsection
