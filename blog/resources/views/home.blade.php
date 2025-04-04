@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row m-4">
        <div class="col-md-12 d-flex flex-row justify-content-around">
            <div class="card" style="width: 10rem;">
                <div class="card-body text-center">
                    <a href="{{route('posts.index')}}">Posts</a>
                </div>
            </div>
        </div>
        <div>
    </div>

    <div>
        {{$posts->links()}}
    </div>
    <div class="row mt-4">
        @foreach($posts as $post)
        <div class="card d-flex flex-row justify-content-around col-md-3" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">{{$post->title}}</h5>
                <a href="{{route('post', $post)}}" class="btn btn-primary">Abrir post</a>
            </div>
        </div>
        @endforeach
    </div>
    <div>
        {{$posts->links()}}
    </div>
</div>
@endsection
