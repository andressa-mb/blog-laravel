<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Blog') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>

    <!-- Scripts Bootstrap -->
{{--     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
{{--     <link href="{{ asset('css/blog.css') }}" rel="stylesheet"> --}}

</head>
<body>
    <div id="app" class="container-fluid">
        <header class="blog-header">
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    {{-- HAMBURGUER --}}
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHamburguerContent" aria-controls="navbarHamburguerContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    {{-- TITULO --}}
                    <a class="navbar-brand mx-auto blog-header-logo" href="{{route('home.index')}}">
                        Blog
                    </a>

                    {{-- lado esquerdo da nav --}}
                    <div class="collapse navbar-collapse text-center" id="navbarHamburguerContent">
                        <ul class="navbar-nav mx-auto">
                            @auth
                                {{-- POSTS --}}
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" id="postDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{__('messages.posts')}}
                                    </a>
                                    <div class="dropdown-menu w-100 text-center" aria-labelledby="postDropdown">
                                        <a class="dropdown-item" href="{{route('web.posts.create')}}">{{__('messages.criar-post')}}</a>
                                        <a class="dropdown-item" href="{{route('web.posts.index')}}">{{__('messages.meus-posts')}}</a>
                                    </div>
                                </li>
                                {{-- CATEGORIAS --}}
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" id="catDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{__('messages.categoria')}}
                                    </a>
                                    <div class="dropdown-menu w-100 text-center" aria-labelledby="catDropdown">
                                        <a class="dropdown-item" href="{{route('web.categories.index')}}"> {{__('messages.categorias')}}</a>
                                    </div>
                                </li>
                                @if ($user->isAdmin())
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" id="listUsersDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{__('messages.usuarios')}}
                                        </a>
                                        <div class="dropdown-menu w-100 text-center" aria-labelledby="listUsersDropdown">
                                            <a class="dropdown-item" href="{{route('list-users')}}">{{__('messages.usuarios')}}</a>
                                        </div>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" id="listPostsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{__('messages.posts')}}
                                        </a>
                                        <div class="dropdown-menu w-100 text-center" aria-labelledby="listPostsDropdown">
                                            <a class="dropdown-item" href="{{route('list-posts')}}">
                                                {{__('messages.posts')}}</a>
                                        </div>
                                    </li>
                                @endif
                            @endauth
                            {{-- IDIOMAS --}}
                            <li class="nav-item">
                                <form action="{{ route('locale.setLang') }}" method="POST" class="">
                                @csrf
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-0">🌐</span>
                                        </div>
                                        <select class="form-select border-0 bg-white" name="lang" onchange="this.form.submit()" required>
                                            <option disabled selected>{{ __('Idioma') }}</option>
                                            <option value="en">🇺🇸 English</option>
                                            <option value="pt-BR">🇧🇷 Português</option>
                                        </select>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </div>

                    <!-- lado direito da Navbar -->
                    <div class="collapse navbar-collapse text-center" id="navbarHamburguerContent">
                        <ul class="navbar-nav ml-auto text-center">
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('messages.login') }}</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('messages.registro') }}</a>
                                    </li>
                                @endif
                            @else
                                <li>
                                    @yield('li-bem-vindo')
                                </li>

                                {{-- NOTIFICAÇÕES --}}
                                <li class="nav-item dropdown mr-4">
                                    <a id="alertDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <img class="text-muted" src="{{asset("storage/sino.png")}}" width="30px" height="30px"/>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertDropdown">
                                        @if($user->alertComments()->exists())
                                            @foreach ($user->alertComments()->get() as $alert)
                                                <a class="dropdown-item" href="{{route('web.posts.show', $alert->post->slug)}}">
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

                                {{-- PERFIL / LOGGOUT --}}
                                <li class="nav-item dropdown mt-2">
                                    <a id="userDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu w-100 text-center" aria-labelledby="userDropdown">
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
            </nav>
        </header>

        <main class="py-4">
            <div id="alert-messages">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('message'))
                    <div class="alert alert-info">
                        <h4>{{session('message')}}</h4>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('warning'))
                    <div class="alert alert-warning">
                        {{ session('warning') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
