@extends('layouts.app')
@section('content')
<div class="row d-flex justify-content-center">
    <div class="col-md-6">
        <form action="{{route('web.posts.store')}}" method="POST">
            @csrf
            <div class="">
                <h3>Novo post</h3>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Título:</label>
                <input type="text" class="form-control" name="title" id="title" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Conteúdo:</label>
                <textarea class="form-control" name="content" id="content" rows="5" cols="5" required></textarea>
            </div>
            <div class="">
                <h3>Categorias</h3>
            </div>
            @foreach ($categories as $cat)
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="cat-{{$cat->id}}" value="{{$cat->id}}" name="categories[]">
                    <label class="form-check-label" for="cat-{{$cat->id}}">{{$cat->name}}</label>
                </div>
            @endforeach
            <button type="submit" class="btn btn-success">Enviar</button>
        </form>
    </div>
</div>
@endsection
