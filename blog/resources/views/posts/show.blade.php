@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row mt-5 m-auto">
        @php
         $imageMain = $post->getMainImage();
         $imagesCommon = $post->getCommonImages();
        @endphp
    @if(!is_null($imageMain))
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
          <div class="carousel-item active">
            <h3 class="text-center">{{$imageMain->description}}</h3>
            <img class="border border-info rounded d-block m-auto" src="{{asset("storage/{$imageMain->path}")}}" style="width: {{$imageMain->width}}; height: {{$imageMain->height}}px;" alt="{{$imageMain->description}}">
          </div>
          @foreach ($imagesCommon as $imageCommon)
            <div class="carousel-item">
                <h3 class="text-center">{{$imageCommon->description}}</h3>
                <img class="rounded d-block m-auto" src="{{asset("storage/{$imageCommon->path}")}}" style="width: {{$imageCommon->width}}px; height: {{$imageCommon->height}}px;" alt="{{$imageCommon->description}}">
            </div>
          @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon bg-black" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon bg-black" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
    </div>
    @endif

    </div>
    <div class="row mt-5">
        <div class="h3 col-md-12 text-center mt-4">
            {{$post->title}}
        </div>

        <div class="card col-md-12">
            {{$post->content}}
        </div>
        <div class="col-md-12 text-center mt-3">
            <strong>Categorias:</strong>
            @foreach($post->categories as $category)
                {{$category->name}}{{$loop->last?'.':', '}}
            @endforeach
        </div>

        <div class="col-md-4 text-right mt-2">
            <strong>Autor(a):</strong> {{$post->user->name}}
        </div>
        <div class="col-md-4 text-right mt-2">
            <strong>Data de criação:</strong> {{$post->created_at->translatedFormat('l, d \d\e F, Y')}}
        </div>
        <div class="col-md-4 text-left mt-2">
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

        @php
            $user = Auth::user();
        @endphp

       @if($user->id == $post->user_id)
       <div class="col-md-6 text-right mt-5">
           <a href="{{route('posts.edit', [$post])}}" class="btn btn-primary">Editar</a>
       </div>
       <div class="col-md-6 text-left mt-5">
           <form action="{{route('posts.destroy', [$post])}}" method="POST">
               @csrf
               @method('DELETE')
               <button type="submit" class="btn btn-danger">Excluir</button>
           </form>
       </div>
       @endif
    </div>

    <div class="col-md-6 mt-2">
        <a href="{{route('posts.index')}}" class="btn btn-primary">Meus posts</a>
    </div>

    @php
        $postsDoUser = $post->where('user_id', $user->id)->get();
        //$postsDoUser = where('user_id', $request->user()->id )->get();
    @endphp

@if (!$postsDoUser->contains($post->id))
    <div class="row mt-5">
        <h3>Comentários:</h3>
        <div class="col-md-12">
            <form action="{{route('comments.store')}}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nome:</label>
                    <input type="text" class="form-control" name="user_id" id="name" disabled aria-describedby="emailHelp" value="{{$user->name}}">
                </div>
                <div class="mb-3">
                  <label for="comment" class="form-label">Comentário:</label>
                  <input type="text" class="form-control @error('comment') is-invalid @enderror" name="comment" id="comment" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <input name="post_id" value="{{$post->id}}" hidden/>
                </div>
                <button type="submit" class="btn btn-success">Enviar Comentário</button>
                @error('comment')
                    <div class="mt-3 alert alert-danger">{{ $message }}</div>
                @enderror
            </form>
        </div>
    </div>
@endif

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
</div>
@endsection
