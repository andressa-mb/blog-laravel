@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-md-12">
        @can('create', \App\Models\Category::class)
            <button class="btn btn-success" data-target="#create_category" data-toggle="modal">
                {{__('messages.criar-categoria')}}
            </button>
        @endcan
    </div>

    <div class="col-md-12 mt-5">
        <div class="row justify-content-center">
            @foreach($categories as $category)
                <div class="card m-3 col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                    <div class="card-body row">
                        <div class="col-md-6 d-flex align-items-center">
                            <h5 class="card-title" style="word-break: break-word;">{{$category->name}}</h5>
                        </div>
                        @if($user->is_admin)
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
                    'title' => __('messages.editar-categoria').'?',
                    'form_id' => "form_edit_$category->id",
                    'btnText' => __('messages.atualizar')
                ])
                    <form action="{{route('web.categories.update', $category)}}" method="POST" id="form_edit_{{$category->id}}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="category-id-{{$category->id}}" class="form-label">{{__('messages.nome-categoria')}}</label>
                            <input type="text" class="form-control" name="name" value="{{$category->name}}" id="category-id-{{$category->id}}" required>
                        </div>
                    </form>
                @endcomponent

                @component('layouts.components.modal', [
                    'modal_id' => "delete_category_$category->id",
                    'title' => __('messages.deletar-categoria').'?',
                    'classBtn' => 'btn btn-danger',
                    'form_id' => "form_delete_$category->id",
                    'btnText' => __('messages.excluir'),
                ])
                    <form action="{{route('web.categories.destroy', $category->id)}}" method="POST" id="form_delete_{{$category->id}}">
                        @csrf
                        @method('DELETE')
                        <p>{{__('text.confirma_exclusao_categoria')}}</p>
                    </form>
                @endcomponent

            @endforeach
        </div>
    </div>
</div>

@component('layouts.components.modal', [
    'modal_id' => 'create_category',
    'title' => __('messages.criar-categoria'),
    'form_id' => 'form_create_category',
    'btnText' => __('messages.cadastrar')
])
    <form action="{{route('web.categories.store')}}" method="POST" id="form_create_category">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">{{__('messages.nome-categoria')}}:</label>
            <input type="text" class="form-control" name="name" id="title" required>
        </div>
    </form>
@endcomponent
@endsection
