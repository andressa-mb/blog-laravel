@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-md-12">
        @component('layouts.components.form-sendData', ['action' => route('web.posts.update', $post), 'btnText' => __('messages.atualizar')])
            @method('PUT')
            <div class="form-group mb-3">
                <label for="title" class="form-label">{{__('messages.titulo')}}</label>
                <input type="text" value="{{$post->title}}" name="title" id="title" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="content" class="form-label">{{__('messages.conteudo')}}</label>
                <textarea name="content" id="content" rows="5" cols="5" class="form-control" required>{{$post->content}}</textarea>
            </div>
            {{-- LISTA DE CATEGORIAS --}}
            <div>
                <h3>{{__('messages.categorias')}}</h3>
            </div>
            @foreach ($categories as $cat)
                @php
                    $checked = in_array($cat->id, $categories_ids);
                @endphp
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="cat-{{$cat->id}}" value="{{$cat->id}}" name="categories[]" {{ $checked ? 'checked' : '' }}>
                    <label class="form-check-label" for="cat-{{$cat->id}}">{{$cat->name}}</label>
                </div>
            @endforeach
        @endcomponent
    </div>
</div>

@endsection
