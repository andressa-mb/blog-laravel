@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="{{route('posts.create')}}" type="button" class="btn btn-success">Criar Post</a>
        </div>
    </div>
    <div class="row mt-5">
        {{$posts->links()}}
        <div class="col-md-12 d-flex flex-row justify-content-around">
            @foreach ($posts as $post)
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">{{$post->title}}</h5>
                    <a href="{{route('posts.show', $post)}}" class="btn btn-primary">Abrir post</a>
                </div>
            </div>
            @endforeach
        </div>
        {{$posts->links()}}
    </div>
</div>
@endsection
