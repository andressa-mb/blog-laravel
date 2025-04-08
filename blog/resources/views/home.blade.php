@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        {{$posts->links()}}
    </div>
    <div class="row m-4">
        @foreach($posts as $post)
        <div class="card d-flex flex-row justify-content-around col-md-3 m-2" style="width: 10rem;">
            <div class="card-body text-center">
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
