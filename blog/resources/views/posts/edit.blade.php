@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('web.posts.update', $post)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                  <label for="title" class="form-label">Título:</label>
                  <input type="text" value="{{$post->title}}" class="form-control" name="title" id="title" aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Conteúdo:</label>
                    <textarea class="form-control" name="content" id="content" rows="5" cols="5" required>
                        {{$post->content}}
                    </textarea>
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
        </div>
    </div>
</div>
@endsection
