@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <form action="{{route('associate-post-to-category', $post)}}" method="POST">
            @csrf
            <p>Selecione as categorias relacionada ao seu post:</p>
            @php($categories_ids = $post->categoriesIds())
            @foreach($categories as $category)
            <div class="form-check">
                <input type="checkbox" id="category--{{$category->id}}" name="categories[]" value="{{$category->id}}"
                @if(in_array($category->id, $categories_ids))
                    checked
                @endif />
                <label for="category--{{$category->id}}">{{$category->name}}</label>
            </div>
            @endforeach
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
</div>
@endsection
