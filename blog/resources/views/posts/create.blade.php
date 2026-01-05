@extends('layouts.app')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        @component('layouts.components.form-sendData', ['action' => route('web.posts.store'), 'btnText' => __('messages.cadastrar')])
            <div class="text-center">
                <h3>{{__('messages.criar-post')}}</h3>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">{{__('messages.titulo')}}</label>
                <input type="text" class="form-control" name="title" id="title" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">{{__('messages.conteudo')}}</label>
                <textarea class="form-control" name="content" id="content" rows="5" cols="5" required></textarea>
            </div>
            {{-- LISTA DE CATEGORIAS --}}
            <div class="">
                <h3>{{__('messages.categorias')}}</h3>
            </div>
            @foreach ($categories as $cat)
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="cat-{{$cat->id}}" value="{{$cat->id}}" name="categories[]">
                    <label class="form-check-label" for="cat-{{$cat->id}}">{{$cat->name}}</label>
                </div>
            @endforeach
        @endcomponent
    </div>
</div>

@endsection
