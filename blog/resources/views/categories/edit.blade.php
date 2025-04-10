@extends('layouts.app')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container">
    <div class="row">
        <div class="col-md-12">
            @can('update', $category)
            <form action="{{route('categories.update', $category)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                  <label for="name" class="form-label">Nome da Categoria:</label>
                  <input type="text" class="form-control" name="name" value="{{$category->name}}" id="name" aria-describedby="emailHelp" required>
                </div>
                <button type="submit" class="btn btn-success">Enviar</button>
                <a href="{{route('categories.index')}}" type="button" class="ml-4 btn btn-primary">Voltar</a>
            </form>
            @endcan
        </div>
    </div>
</div>
@endsection
