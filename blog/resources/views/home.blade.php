@extends('layouts.app')
@section('content')
<div class="row">
    @if ($post)
        <div class="col-md-12">
            <div class="row p-4 mb-4 rounded text-white bg-dark">
                <div class="col-lg-6 px-0">
                    <h1 class="display-4 font-italic">{{$post->title}}</h1>
                    <div class="mb-1 text-muted">
                        <em>Autor(a): {{$post->author->name}}</em>
                        <br>
                        <em>{{$post->created_at->translatedFormat('l, d \d\e F, Y')}}</em>
                    </div>
                    <p class="lead my-3">{{Str::limit($post->content, 200)}}</p>
                    <p class="lead mb-0">
                        <a href="{{route('web.posts.show', $post)}}" class="text-decoration-none text-white-50">
                            {{__('messages.continuar-lendo')}}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if($posts)
        <div class="row mx-3">
            <div class="col-md-12">
                @component('layouts.components.page-links')
                    {{$posts->appends(Request::query())->links()}}
                @endcomponent

                <div class="row">
                    @foreach($posts as $post)
                        @include('layouts.components.post-details', ['post' => $post])
                    @endforeach
                </div>

                @component('layouts.components.page-links')
                    {{$posts->appends(Request::query())->links()}}
                @endcomponent
            </div>
        </div>
    @endif

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-8">
                <h3 class="pb-3 mb-4 mx-3 font-italic border-bottom">
                    Posts mais recentes
                </h3>
                @if ($recentPosts)
                    @foreach ($recentPosts as $post)
                        <div class="mx-3 border border-black p-2">
                            <h2> {{$post->title}}</h2>
                            <p class="text-muted">
                                {{$post->created_at->translatedFormat('l, d \d\e F, Y')}} by
                                <a href="{{route('web.users.show', $post->author->id)}}" class="text-white bg-dark text-decoration-none font-italic">{{$post->author->name}}</a>
                            </p>
                            <p>{{$post->content}}</p>
                        </div>
                    @endforeach
                @else
                    <p class="mx-3">Não há posts registrados.</p>
                @endif
            </div>

            <aside class="col-md-4">
                <div class="p-3 mb-3 mx-3 bg-light rounded">
                    <h4 class="font-italic">Sobre</h4>
                    <p class="">
                       Blog criado como forma de juntar <em>várias comunidades</em> num local para postar as informações que gostem, compartilhar ideias, etc.
                    </p>
                </div>

                <div class="p-3 mb-3 mx-3">
                    <h4 class="font-italic">Usuários mais recentes inscritos</h4>
                    <ol class="list-unstyled mb-0">
                        @foreach ($users as $blogger)
                            <li>
                                <a href="{{route('web.users.show', $blogger)}}" class="text-black-50 text-decoration-none font-italic">
                                    {{$blogger->name}} desde {{$blogger->created_at->format('d-m-Y')}}
                                </a>
                            </li>
                        @endforeach
                        <li><a href="{{route('web.users.index')}}" class="text-dark text-decoration-none font-weight-bold">Ver todos</a></li>
                    </ol>
                </div>

                <div class="p-3 mx-3">
                    <h4 class="font-italic">Redes Sociais</h4>
                    <ol class="list-unstyled">
                        <li><a href="#" class="text-dark text-decoration-none">GitHub</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Twitter</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Facebook</a></li>
                    </ol>
                </div>
            </aside>
        </div>
    </div>

    <footer class="col-md-12">
        <p class="mx-3">
            Blog template built for <a href="https://getbootstrap.com/" class="text-dark text-decoration-none font-italic">Bootstrap</a> by <a href="https://twitter.com/mdo" class="text-dark text-decoration-none font-italic">@mdo</a>.
        </p>
        <p class="mx-3">
            <a href="#" class="text-dark text-decoration-none font-weight-bold">Back to top</a>
        </p>
    </footer>
</div>
@endsection
