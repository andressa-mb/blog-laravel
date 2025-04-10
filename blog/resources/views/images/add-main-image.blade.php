@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-3">
            <h3>Adicionar imagem principal:</h3>
            <form action="{{route('posts.add-main-image', $post)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <input type="text" name="description" class="form-control" placeholder="Descrição da imagem."/>
                </div>
                <div class="mb-3">
                    <input type="file" name="image" class="form-control" required/>
                </div>
                <button type="submit" id="btn" class="btn btn-success">Enviar imagem</button>
            </form>
        </div>
    </div>
    <div class="mt-2">
        <a href="{{route('posts.show', $post)}}" class="btn btn-danger">Não quero acrescentar imagens</a>
    </div>
</div>
@endsection
