@extends('layouts.app')

@section('content')
@if (session('message'))
    <div class="alert alert-sucess">
        <h4>{{session('message')}}</h4>
    </div>
@endif
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="{{route('categories.create')}}" type="button" class="btn btn-success">Criar Categoria</a>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-12 d-flex flex-row justify-content-around">
        @foreach($categories as $category)
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">{{$category->name}}</h5>
                    <div class="d-flex justify-content-around">
                        <a href="{{route('categories.edit', $category->id)}}" class="btn btn-primary">Editar</a>
                        <form action="{{route('categories.destroy', $category->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
</div>
@endsection
