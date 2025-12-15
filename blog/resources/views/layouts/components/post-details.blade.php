@php($thumb = $post->imagesPost()->where('type', 3)->first())

<div class="col-md-6">
    <div class="card mb-3 shadow p-3 mb-5 bg-white rounded">
        <div class="row no-gutters">
            <div class="col-md-8">
                <div class="card-body">
                    <strong class="d-inline-block mb-2 text-primary">
                        {{optional($post->categories()->first())->name}}
                    </strong>
                    <h4 class="card-title">
                        <a class="text-dark" href="{{route('web.posts.show', $post)}}">{{$post->title}}</a>
                    </h4>
                    <p class="card-text mb-0">Autor: {{$post->author->name}}</p>
                    <div class="card-text text-muted mb-3">
                        <small>{{$post->created_at->translatedFormat('l, d \d\e F, Y')}}</small>
                    </div>
                    <p class="card-text">{{Str::limit($post->content, 60)}}</p>
                    <a href="{{route('web.posts.show', $post)}}" class="card-text text-decoration-none text-black-50 ">
                        {{__('messages.continuar-lendo')}}
                    </a>
                </div>
            </div>
            @if(!is_null($thumb))
                <div class="col-md-4 d-flex justify-content-end">
                    <img src="{{asset("storage/{$thumb->path}")}}" alt="{{$thumb->description}}" width="{{$thumb->width}}" height="{{$thumb->height}}">
                </div>
            @endif
        </div>
    </div>
</div>
