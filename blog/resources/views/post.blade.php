@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-5 border rounded">
        <div class="h3 col-md-12 text-center mt-4">
            {{$post->title}}
        </div>
        <div class="col-md-6 text-right">
            <strong>Autor(a):</strong> {{$post->user->name}}
        </div>
        <div class="card col-md-6">
            {{$post->content}}
        </div>
        <div class="col-md-12 text-center ml-5 mt-3">
            <strong>Categorias:</strong>
            @foreach($post->categories as $category)
                {{$category->name}}{{$loop->last?'.':', '}}
            @endforeach
        </div>

        <div class="col-md-6 text-right mt-5">
            <strong>Data de criação:</strong> {{$post->created_at->translatedFormat('l, d \d\e F, Y')}}
        </div>
        <div class="col-md-6 text-left mt-5">
            <strong>Há:</strong>
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
    </div>
    <div class="col-md-6 mt-2">
        <a href="{{route('home')}}" class="btn btn-primary">Voltar</a>
    </div>
</div>
@endsection
