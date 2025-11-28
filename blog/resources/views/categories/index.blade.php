@extends('layouts.app')
@section('content')

<div class="row">

    <div class="col-md-12">
        @can('create', \App\Models\Category::class)
            <button class="btn btn-success" data-target="#create_category" data-toggle="modal">
                Criar Categoria
            </button>
        @endcan
    </div>

    <div class="col-md-12 mt-5">
        <div class="row justify-content-center">
            @foreach($categories as $category)
                <div class="card m-3 col-2">
                    <div class="card-body row">
                        <div class="col-md-6 d-flex align-items-center">
                            <h5 class="card-title">{{$category->name}}</h5>
                        </div>
                        @if($user->isAdmin())
                            <div class="col-md-6">
                                <div class="row">
                                    <button class="btn col-12" data-target="#edit_category_{{$category->id}}" data-toggle="modal" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </div>
                                <div class="row">
                                    <button class="btn col-12" data-target="#delete_category_{{$category->id}}" data-toggle="modal" title="Excluir">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @component('layouts.components.modal', [
                    'modal_id' => "edit_category_$category->id",
                    'title' => 'Editar Categoria',
                    'form_id' => "form_edit_$category->id",
                    'btnText' => 'Atualizar'
                ])
                    <form action="{{route('web.categories.update', $category)}}" method="POST" id="form_edit_{{$category->id}}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="category-id-{{$category->id}}" class="form-label">Nome da Categoria:</label>
                            <input type="text" class="form-control" name="name" value="{{$category->name}}" id="category-id-{{$category->id}}" required>
                        </div>
                    </form>
                @endcomponent

                @component('layouts.components.modal', [
                    'modal_id' => "delete_category_$category->id",
                    'title' => 'Excluir categoria?',
                    'classBtn' => 'btn btn-danger',
                    'form_id' => "form_delete_$category->id",
                    'btnText' => 'Excluir',
                ])
                    <form action="{{route('web.categories.destroy', $category->id)}}" method="POST" id="form_delete_{{$category->id}}">
                        @csrf
                        @method('DELETE')
                        <p>Tem certeza que quer excluir a categoria selecionada?</p>
                    </form>
                @endcomponent

            @endforeach
        </div>
    </div>
</div>

@component('layouts.components.modal', [
    'modal_id' => 'create_category',
    'title' => 'Criar Categoria',
    'form_id' => 'form_create_category',
    'btnText' => 'Cadastrar'
])
    <form action="{{route('web.categories.store')}}" method="POST" id="form_create_category">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nome da Categoria:</label>
            <input type="text" class="form-control" name="name" id="title" required>
        </div>
    </form>
@endcomponent
@endsection
