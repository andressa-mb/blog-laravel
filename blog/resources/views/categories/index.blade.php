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
            @can('create', \App\Models\Category::class)
            <a href="{{route('categories.create')}}" type="button" class="btn btn-success">
                Criar Categoria
            </a>
            @endcan
        </div>
    </div>
    <div class="row m-4">
        @php
            $isAdmin = auth()->user()->isAdmin();
        @endphp
        @foreach($categories as $category)
        <div class="card d-flex flex-row justify-content-around col-md-3 m-2" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">{{$category->name}}</h5>
                <div class="d-flex justify-content-around">
                    @if($isAdmin)
                    <a href="{{route('categories.edit', $category->id)}}" class="btn btn-primary">Editar</a>

                    <form action="{{route('categories.destroy', $category->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
