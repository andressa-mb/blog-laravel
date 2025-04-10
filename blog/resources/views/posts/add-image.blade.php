@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-3">
            <h3>Adicionar imagem principal:</h3>
            <form action="{{route('posts.add-main-image', $post)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <input type="file" name="image" class="form-control" required onchange="this.form.submit()"/>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3">
            <h3>Adicionar imagem thumbnail:</h3>
            <form action="{{route('posts.add-thumb-image', $post)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <input type="file" name="image" class="form-control" required onchange="this.form.submit()"/>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3">
            <h3>Adicionar imagem:</h3>
            <form action="{{route('posts.add-common-image', $post)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <input type="file" name="image" class="form-control" required onchange="this.form.submit()"/>
                </div>
            </form>
        </div>
    </div>
<br><br>
    <a href="{{route('posts.show', $post)}}" class="btn btn-primary">Post Concluído</a>
</div>
@endsection
