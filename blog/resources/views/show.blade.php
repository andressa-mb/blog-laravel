@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-5 border rounded">
        @php
        $image = $post->getMainImage();
        @endphp
        @if(!is_null($image))
        <img src="{{asset("storage/{$image->path}")}}" width="{{$image->width}}" height="{{$image->height}}" alt="Imagem teste">
        @endif
        <div class="h3 col-md-12 text-center mt-4">
            {{$post->title}}
        </div>
        <div class="col-md-6 text-right">
            <strong>Autor(a):</strong> {{$post->user->name}}
        </div>
        <div class="card col-md-6">
            {{$post->content}}
        </div>
        <div class="col-md-12 text-center ml-5 mt-3">
            <strong>Categorias:</strong>
            @foreach($post->categories as $category)
                {{$category->name}}{{$loop->last?'.':', '}}
            @endforeach
        </div>

        <div class="col-md-6 text-right mt-5">
            <strong>Data de criação:</strong> {{$post->created_at->translatedFormat('l, d \d\e F, Y')}}
        </div>
        <div class="col-md-6 text-left mt-5">
            <strong>Há:</strong>
             @php
                 $minutes = $post->created_at->diffInMinutes(now());
                 $hours = $post->created_at->diffInHours(now());
             @endphp
             @if($minutes >= 60)
             {{trans_choice('messages.hours_ago', $hours, ['value' => $hours])}}
             @else
             {{trans_choice('messages.minutes_ago', $minutes, ['value' => $minutes])}}
             @endif
        </div>
    </div>
@auth
    <div class="row mt-5">
        <h3>Comentários:</h3>
        <div class="col-md-12">
            <form action="{{route('comments.store')}}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nome:</label>
                    <input type="text" class="form-control" name="user_id" id="name_user" disabled aria-describedby="emailHelp" value="{{$user->name}}">
                </div>
                <div class="mb-3">
                  <label for="comment" class="form-label">Comentário:</label>
                  <input type="text" class="form-control" name="comment" id="comment" aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3">
                    <input name="post_id" {{$post->id}} hidden />
                </div>
                <button type="submit" class="btn btn-success">Enviar Comentário</button>
            </form>
        </div>
    </div>
@endauth
    <div class="row mt-5">
        <h3 class="mb-5">Comentários anteriores</h3>
        @foreach($post->comments as $comment)
        <div class="card d-flex flex-row justify-content-around col-md-6 m-2" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"> <strong>Autor(a):</strong> {{$comment->user->name}}</h5>
                <div class="card">
                    {{$comment->comments}}
                </div>
                <div class="text-left">
                    <strong>Data de criação:</strong> {{$comment->created_at->translatedFormat('l, d \d\e F, Y')}}
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="col-md-6 mt-2">
        <a href="{{route('home.index')}}" class="btn btn-primary">Voltar</a>
    </div>
</div>
@endsection
