@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="{{route('posts.create')}}" type="button" class="btn btn-success">Criar Post</a>
        </div>
    </div>

    <div class="row m-4">
        {{$posts->links()}}
        @foreach ($posts as $post)
        @php
        $thumb = $post->getThumb();
        @endphp
        <div class="card d-flex flex-row justify-content-around col-md-3 m-2" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">{{$post->title}}</h5>
                <a href="{{route('posts.show', $post)}}" class="btn btn-primary">Abrir post</a>
                @if(!is_null($thumb))
                    <img src="{{asset("storage/{$thumb->path}")}}" width="{{$thumb->width}}" height="{{$thumb->height}}">
                @endif
            </div>
        </div>
        @endforeach
        {{$posts->links()}}
    </div>
</div>
@endsection
