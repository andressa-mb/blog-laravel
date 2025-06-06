<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Blog') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Scripts Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/blog.css') }}" rel="stylesheet">

</head>
<body>
<div id="app" class="container-fluid">
    <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-2 pt-1 text-right">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{__('messages.posts')}}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{route('posts.create')}}">{{__('messages.criar-post')}}</a>
                                <a class="dropdown-item" href="{{route('posts.index')}}">{{__('messages.meus-posts')}}</a>
                            </div>
                        </li>
                    @endauth
                </ul>
            </div>
            <div class="col-2 pt-1 text-left">
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{__('messages.categoria')}}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @can('create', \App\Models\Category::class)
                                <a class="dropdown-item" href="{{route('categories.create')}}"> {{__('messages.criar-categoria')}}</a>
                                @endcan

                                <a class="dropdown-item" href="{{route('categories.index')}}"> {{__('messages.categorias')}}</a>
                            </div>
                        </li>
                    @endauth
                </ul>
            </div>
            <div class="col-4 text-center">
                <a class="blog-header-logo text-dark" href="{{route('home.index')}}">Blog</a>
            </div>
            <div class="col-4 d-flex justify-content-end align-items-center">
                <form action="{{route('locale.setLang')}}" method="POST">
                    @csrf
                    <select class="" name="lang" onchange="this.form.submit()" required>
                        <option>{{__('messages.'. session('locale', config('app.locale')))}}</option>
                        <option value="en">{{__('messages.ingles')}}</option>
                        <option value="pt-BR">{{__('messages.portugues')}}</option>
                    </select>
                </form>
                <ul class="navbar-nav d-flex flex-row ml-4">
                    @guest
                        <li class="nav-item mr-4">
                            <a class="nav-link p-2 btn btn-md btn-outline-secondary" href="{{ route('login') }}">{{ __('messages.login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link p-2 btn btn-md btn-outline-secondary" href="{{ route('register') }}">{{ __('messages.registro') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown mr-4">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle p-2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <img class="text-muted" src="{{asset("storage/sino.png")}}" width="30px" height="30px"/>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if($user->alertComments()->exists())
                                    @foreach ($user->alertComments()->get() as $alert)
                                        <a class="dropdown-item" href="{{route('posts.show', $alert->post->slug)}}">
                                            <p>Novo comentário de: {{$alert->comment->user->name}} em {{$alert->created_at->format('d-m-Y')}}</p>
                                        </a>
                                    @endforeach
                                @endif
                                @if($user->followings()->exists())

                                    @if($user->hasPostAlerts())
                                        @foreach ($user->notReadedPostAlerts()->get() as $alert)
                                            <a class="dropdown-item" href="{{route('alert-following-post', $alert)}}">
                                                <p>Novo post: {{$alert->author->name}} em {{$alert->created_at->format('d-m-Y')}}</p>
                                            </a>
                                        @endforeach
                                    @endif
                                @endif
                                @if($user->newFollowerAlerts()->exists())
                                    @php($newFollow = $user->newFollowerAlerts()->orderBy('created_at', 'desc')->first())
                                    <a class="dropdown-item" href="{{route('show-perfil', $user)}}">
                                        <p>Novo seguidor: {{$newFollow->author->name}} em {{$newFollow->created_at->format('d-m-Y')}}</p>
                                    </a>
                                @endif
                            </div>
                        </li>

                        <li class="nav-item dropdown mr-4 d-flex align-items-center">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{route('show-perfil', Auth::user()->id)}}">
                                    Meu perfil
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{__('messages.posts')}}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('posts.create')}}">{{__('messages.criar-post')}}</a>
                            <a class="dropdown-item" href="{{route('posts.index')}}">{{__('messages.meus-posts')}}</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{__('messages.categoria')}}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @can('create', \App\Models\Category::class)
                            <a class="dropdown-item" href="{{route('categories.create')}}"> {{__('messages.criar-categoria')}}</a>
                            @endcan
                            <a class="dropdown-item" href="{{route('categories.index')}}"> {{__('messages.categorias')}}</a>
                        </div>
                    </li>
                @endauth
                    <form action="{{route('locale.setLang')}}" method="POST">
                        @csrf
                        <select class="form-control" name="lang" onchange="this.form.submit()" required>
                            <option></option>
                            <option value="en">{{__('messages.ingles')}}</option>
                            <option value="pt-BR">{{__('messages.portugues')}}</option>
                        </select>
                    </form>
            </ul>
        </div>
    </div>



    <div class="nav-scroller py-1 mb-2">
        <nav class="nav d-flex justify-content-between">
        @foreach (\App\Models\Category::get() as $category)
            <a class="p-2 text-muted" href="#">{{$category->name}}</a>
        @endforeach
        </nav>
    </div>

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
