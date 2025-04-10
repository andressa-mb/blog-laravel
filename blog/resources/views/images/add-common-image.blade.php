@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-3">
            <h3>Adicionar imagem:</h3>
            <form action="{{route('posts.add-common-image', $post)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <input type="text" name="description" class="form-control" placeholder="Descrição da imagem."/>
                </div>
                <div class="mb-3">
                    <input type="file" name="image" class="form-control" required onchange="this.form.submit()"/>
                </div>
            </form>
        </div>
    </div>

    <a href="{{route('posts.show', $post)}}" class="btn btn-primary mt-4">Post Concluído</a>
</div>
@endsection
