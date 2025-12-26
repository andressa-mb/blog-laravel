@extends('layouts.app')
@section('content')

<div class="row">
    @php
        $imageMain = $post->images()->getMainImgPost()->first();
        $imagesCommon = $post->images()->getCommonImgPost()->get();
        $isPostCreator = $user ? $user->id == $post->user_id : null;
    @endphp
    <div class="col-md-12">
        @if(!is_null($imageMain))
            <div id="imagesCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <h3 class="text-center text-capitalize">{{$imageMain->description}}</h3>
                        <img class="border border-info rounded d-block m-auto" src="{{asset("storage/{$imageMain->path}")}}" width="{{$imageMain->width}}" height="{{$imageMain->height}}" alt="{{$imageMain->description}}">
                    </div>
                    @foreach ($imagesCommon as $imageCommon)
                        <div class="carousel-item">
                            <h3 class="text-center text-capitalize">{{$imageCommon->description}}</h3>
                            <img class="rounded d-block m-auto" src="{{asset("storage/{$imageCommon->path}")}}" width="{{$imageCommon->width}}" height="{{$imageCommon->height}}" alt="{{$imageCommon->description}}">
                        </div>
                    @endforeach
                </div>

                <a class="carousel-control-prev" href="#imagesCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next"  href="#imagesCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        @endif
    </div>
    {{-- DADOS POST --}}
    <div class="col-md-12">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
                <div class="w-50 m-auto">
                    <div class="col-md-12">
                        <h3 class="text-capitalize text-center">{{$post->title}}</h3>
                    </div>
                    <div class="col-md-12">
                        <strong>Categorias:</strong>
                        @foreach($post->categories as $category)
                            <span>{{$category->name}}{{$loop->last?'.':', '}}</span>
                        @endforeach
                    </div>
                    <div class="card col-md-12 px-5 my-3">
                        <p>{{$post->content}}</p>
                    </div>

                    <div class="col-md-12">
                        <strong>Autor(a):</strong> {{$post->user->name}}
                    </div>
                    <div class="col-md-12">
                        <strong>Data de criação:</strong> {{$post->created_at->translatedFormat('l, d \d\e F, Y')}}
                    </div>
                    <div class="col-md-12">
                        <strong>Há:</strong>
                        @php
                            $minutes = $post->created_at->diffInMinutes(now());
                            $hours = $post->created_at->diffInHours(now());
                            $days = floor($hours / 24);
                            $rest = $hours - ($days*24);
                        @endphp
                        @if($hours >= 24)
                            {{trans_choice('messages.days_ago', $days, ['value' => $days, 'hours' => $rest])}}
                        @elseif($minutes >= 60)
                            {{trans_choice('messages.hours_ago', $hours, ['value' => $hours])}}
                        @else
                            {{trans_choice('messages.minutes_ago', $minutes, ['value' => $minutes])}}
                        @endif
                    </div>

                    {{-- BOTÕES DE AÇÃO --}}
                    @if($isPostCreator)
                        <div class="row">
                            <div class="col-md-6 text-right">
                                <a href="{{route('web.posts.edit', [$post])}}" class="btn btn-primary">Editar</a>
                            </div>
                            <div class="col-md-6 text-left">
                                <button type="button" class="btn btn-danger"
                                data-toggle="modal" data-target="#modal_post_delete">
                                    Excluir
                                </button>
                            </div>
                        </div>
                    @endif

                    {{-- MEUS POSTS --}}
                    @auth
                        <div class="col-md-12 mt-2 d-flex justify-content-end">
                            <a href="{{route('web.users.show', $user)}}" class="btn btn-info">Meus posts</a>
                        </div>
                    @endauth
                </div>
            </div>

            @component('layouts.components.modal', [
                'modal_id' => 'modal_post_delete',
                'title' => 'Excluir post?',
                'classBtn' => 'btn btn-danger',
                'form_id' => 'confirm-post-delete',
                'btnText' => 'Excluir',
            ])

                <form action="{{route('web.posts.destroy', [$post])}}" method="POST" id="confirm-post-delete">
                    @csrf
                    @method('DELETE')
                    <p>Tem certeza que quer excluir o post selecionado?</p>
                </form>
            @endcomponent
        </div>
    </div>


    @auth
        @if (!$isPostCreator)
            {{-- SEGUIR --}}
            <div class="col-md-12 mt-2">
                <div class="w-50 mx-auto">
                    @if($user->isFollowing($post->author))
                        <form action="{{route('unfollow-author', $post->author)}}" method="POST" class="form-control" style="width: 22rem">
                            @csrf
                            @method('DELETE')
                            <div class="form-check">
                                <input class="form-check-input" id="unfollow" onchange="this.form.submit()" type="checkbox" name="following"
                                    checked
                                />
                                <label for="unfollow" class="form-check-label">Deixar de Seguir {{$post->author->name}}</label>
                            </div>
                        </form>
                    @else
                        <form action="{{route('follow-author', $post->author)}}" method="POST" class="form-control" style="width: 22rem">
                            @csrf
                            <div class="form-check">
                                <input class="form-check-input" id="follow" onchange="this.form.submit()" type="checkbox" name="following"
                                />
                                <label for="follow" class="form-check-label">Seguir {{$post->author->name}}</label>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

            {{-- ADD COMENTÁRIOS --}}
            <div class="col-md-12 m-5">
                <div class="row justify-content-center mx-auto w-50">
                    <div class="col-md-12">
                        <h3>Adicionar comentários:</h3>
                        <form action="{{route('web.comments.store')}}" method="POST">
                            @csrf
                            <div class="form-group row mb-3">
                                <label for="name" class="form-label col-md-3">Nome:</label>
                                <input type="text" class="form-control col-md-9" name="user_id" id="name" value="{{$user->name}}" disabled>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="comment" class="form-label col-md-3">Comentário:</label>
                                <textarea type="text" class="form-control col-md-9" name="comment" id="comment" @error('comment') is-invalid @enderror></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <input name="post_id" value="{{$post->id}}" hidden/>
                            </div>
                            <button type="submit" class="btn btn-success">Enviar Comentário</button>
                            @error('comment')
                                <div class="mt-3 alert alert-danger">{{ $message }}</div>
                            @enderror
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endauth

    {{-- COMENTÁRIOS DO POST --}}
    @if ($post->comments()->exists())
        <div class="col-md-12">
            <div class="row">
                <h3 class="col-md-12 text-center">Comentários</h3>
                @foreach($post->comments()->orderBy('created_at', 'desc')->get() as $comment)
                    <div class="d-flex justify-content-around col my-3" width="25rem">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <strong>Autor(a): </strong>{{$comment->user->name}}
                                </h5>
                            </div>
                            <div class="card-body">
                                <p>{{$comment->comment}}</p>
                            </div>
                            <div class="card-footer">
                                <p class="text-right">
                                    <strong>Data de criação:</strong> {{$comment->created_at->format('d/m/Y')}}
                                </p>
                                @if ($user && $comment->user->id === $user->id)
                                    <div class="row">
                                        <div class="col-md-6 text-right">
                                            <button type="button" class="btn btn-sm btn-primary"
                                            data-toggle="modal" data-target="#modal_comment_edit_{{$comment->id}}">
                                                Editar
                                            </button>
                                        </div>
                                        <div class="col-md-6 text-left">
                                            <button type="button" class="btn btn-sm btn-danger"
                                            data-toggle="modal" data-target="#modal_comment_delete_{{$comment->id}}">
                                                Excluir
                                            </button>
                                        </div>
                                        @component('layouts.components.modal', [
                                            'modal_id' => "modal_comment_edit_$comment->id",
                                            'title' => 'Editar comentário?',
                                            'classBtn' => 'btn btn-warning',
                                            'form_id' => "confirm-comment-edit-$comment->id",
                                            'btnText' => 'Atualizar',
                                        ])

                                            <form action="{{route('web.comments.update', [$comment])}}" method="POST" id="confirm-comment-edit-{{$comment->id}}">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <label for="comment-{{$comment->id}}" class="form-label col-md-4">Comentário</label>
                                                    <textarea type="text" id="comment-{{$comment->id}}" name="comment" cols="3" rows="3" class="form-control col-md-8">{{$comment->comment}}</textarea>
                                                </div>
                                            </form>
                                        @endcomponent

                                        @component('layouts.components.modal', [
                                            'modal_id' => "modal_comment_delete_$comment->id",
                                            'title' => 'Excluir comentário?',
                                            'classBtn' => 'btn btn-danger',
                                            'form_id' => "confirm-comment-delete-$comment->id",
                                            'btnText' => 'Excluir',
                                        ])

                                            <form action="{{route('web.comments.destroy', [$comment])}}" method="POST" id="confirm-comment-delete-{{$comment->id}}">
                                                @csrf
                                                @method('DELETE')
                                                <p>Tem certeza que quer excluir o seu comentário?</p>
                                            </form>
                                        @endcomponent
                                    </div>

                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
