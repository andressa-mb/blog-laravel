@extends('layouts.app')
@section('content')
<div class=" row">
    @foreach($commentsForPost as $postData)
        <div class="col">
            <div class="jumbotron">
                <img src="{{asset("storage/{$postData['post']['imagePath']}")}}" alt="{{$postData['post']['imageDescription']}}" width="150">

                <h2 class="display-4">{{$postData['post']['title']}}</h2>
                <p class="lead">{{$postData['post']['content']}}</p>
                <hr class="my-4">
                <h4>
                    {{__('messages.comentarios')}}
                    <br>
                    <span class="text-muted">{{__('messages.total_comentarios')}}: {{$postData['comments']->count()}}</span>
                </h4>
                <hr>

                @foreach($postData['comments']->forPage(1, 5) as $comment)
                @php
                    $dateCarbon = Carbon\Carbon::parse($comment->created_at);
                @endphp
                    <p>
                        <span class="text-muted">{{$comment->userName}} em {{$dateCarbon->format('d/m/Y')}}:</span>
                        <br>
                        <span>{{$comment->comment}}</span>

                    </p>
                @endforeach

                <div class="text-right">
                    <a class="btn btn-primary btn-sm" href="{{route('web.posts.show', $postData['post']['slug'])}}" role="button">{{__('messages.ver-todos')}}</a>
                </div>
            </div>

        </div>
    @endforeach
</div>
@endsection
