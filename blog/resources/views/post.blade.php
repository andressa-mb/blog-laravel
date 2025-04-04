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
            Criado: {{$post->created_at->format('l jS \o\f F Y h:i:s A')}}
        </div>
    </div>

    <div class="m-2 col-md-6 d-flex flex-row justify-content-start">
        <a href="{{route('home')}}" class="btn btn-primary">Voltar</a>
    </div>
</div>
@endsection
