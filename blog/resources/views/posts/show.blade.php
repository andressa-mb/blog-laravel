@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-5 border border-primary rounded">
        <div class="h3 mt-4 col-md-12 d-flex flex-row justify-content-around">
            {{$post->title}}
        </div>
        <div class="mt-5 card col-md-12 d-flex flex-row justify-content-around">
            {{$post->content}}
        </div>
        <div class="h4 mt-4 col-md-6 d-flex flex-row justify-content-center">
            Autor(a): {{$post->user->name}}
        </div>
        <div class="h4 mt-4 col-md-6 d-flex flex-row justify-content-center">
            Criado: {{$post->created_at->translatedFormat('l, d \d\e F, Y')}}
        </div>

        <div class="h4 mt-4 col-md-6 d-flex flex-row justify-content-center">

             @php
                 $minutes = $post->created_at->diffInMinutes(now());
                 $hours = $post->created_at->diffInHours(now());
             @endphp
             @if($minutes >= 60)
             {{trans_choice('messages.hours_ago', $hours, ['value' => $hours])}}
             @else
             {{trans_choice('messages.minutes_ago', $minutes, ['value' => $minutes])}}
             @endif
        </div>
        <div class="m-2 col-md-6 d-flex flex-row justify-content-start">
            <a href="{{route('posts.edit', [$post])}}" class="btn btn-primary">Editar</a>
        </div>
        <div class="m-2 col-md-6 d-flex flex-row justify-content-start">
            <form action="{{route('posts.destroy', [$post])}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Excluir</button>
            </form>
        </div>
    </div>

    <div class="m-2 col-md-6 d-flex flex-row justify-content-start">
        <a href="{{route('posts.index')}}" class="btn btn-primary">Voltar</a>
    </div>
</div>
@endsection
