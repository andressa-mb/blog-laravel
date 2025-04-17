@extends('layouts.home')

@section('content')

      <div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
        <div class="col-md-6 px-0">
          <h1 class="display-4 font-italic">{{$post->title}}</h1>
          <p>Autor: {{$post->author->name}}</p>
          <div class="mb-1 text-muted">{{$post->created_at->translatedFormat('l, d \d\e F, Y')}}</div>
          <p class="lead my-3">{{Str::limit($post->content, 200)}}</p>
          <p class="lead mb-0"><a href="{{route('posts.show', $post)}}" class="text-white font-weight-bold">{{__('messages.continuar-lendo')}}</a></p>
        </div>
      </div>

    @component('layouts.components.page-links')
    {{$posts->appends(Request::query())->links()}}
    @endcomponent

      <div class="row mb-2">
        @foreach($posts as $post)
            @include('layouts.components.post-details', ['post' => $post])
        @endforeach
      </div>
    @component('layouts.components.page-links')
      {{$posts->appends(Request::query())->links()}}
    @endcomponent

    <main role="main" class="container">
      <div class="row">
        <div class="col-md-8 blog-main">
          <h3 class="pb-3 mb-4 font-italic border-bottom">
            Posts mais recentes
          </h3>
            @foreach ($recentPosts as $post)
                <div class="blog-post">
                    <h2 class="blog-post-title"> {{$post->title}}</h2>
                    <p class="blog-post-meta">{{$post->created_at->translatedFormat('l, d \d\e F, Y')}} by <a href="#">{{$post->author->name}}</a></p>
                    <p>{{$post->content}}</p>
                </div>
            @endforeach
{{--
          <nav class="blog-pagination">
            <a class="btn btn-outline-primary" href="#">Older</a>
            <a class="btn btn-outline-secondary disabled" href="#">Newer</a>
          </nav> --}}
        </div>
        <!-- /.blog-main -->

        <aside class="col-md-4 blog-sidebar">
          <div class="p-3 mb-3 bg-light rounded">
            <h4 class="font-italic">Sobre</h4>
            <p class="mb-0">Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
          </div>

          <div class="p-3">
            <h4 class="font-italic">Archives</h4>
            <ol class="list-unstyled mb-0">
              <li><a href="#">March 2014</a></li>
              <li><a href="#">February 2014</a></li>
              <li><a href="#">January 2014</a></li>
              <li><a href="#">December 2013</a></li>
              <li><a href="#">November 2013</a></li>
              <li><a href="#">October 2013</a></li>
              <li><a href="#">September 2013</a></li>
              <li><a href="#">August 2013</a></li>
              <li><a href="#">July 2013</a></li>
              <li><a href="#">June 2013</a></li>
              <li><a href="#">May 2013</a></li>
              <li><a href="#">April 2013</a></li>
            </ol>
          </div>

          <div class="p-3">
            <h4 class="font-italic">Elsewhere</h4>
            <ol class="list-unstyled">
              <li><a href="#">GitHub</a></li>
              <li><a href="#">Twitter</a></li>
              <li><a href="#">Facebook</a></li>
            </ol>
          </div>
        </aside><!-- /.blog-sidebar -->

      </div><!-- /.row -->

    </main><!-- /.container -->

    @auth
        @foreach ($user->newFollowerAlerts()->isReaded(false)->get() as $alertFollow)
            {{$alertFollow->follower->name}} <br>
            {{$alertFollow->created_at->format('d-m-Y')}}
        @endforeach
    @endauth

    <footer class="blog-footer">
      <p>Blog template built for <a href="https://getbootstrap.com/">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
      <p>
        <a href="#">Back to top</a>
      </p>
    </footer>
@endsection
