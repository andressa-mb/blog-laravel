@php($image = $post->getThumb())

<div class="col-md-6">
    <div class="card flex-md-row mb-4 box-shadow h-md-250">
    <div class="card-body d-flex flex-column align-items-start">
        <strong class="d-inline-block mb-2 text-primary">{{optional($post->categories()->first())->name}}</strong>
        <h3 class="mb-0">
        <a class="text-dark" href="#">{{$post->title}}</a>
        </h3>
        <p>Autor: {{$post->author->name}}</p>
        <div class="mb-1 text-muted">{{$post->created_at->translatedFormat('l, d \d\e F, Y')}}</div>
        <p class="card-text mb-auto">{{Str::limit($post->content, 60)}}</p>
        <a href="{{route('posts.show', $post)}}">{{__('messages.continuar-lendo')}}</a>
    </div>
    @if(!is_null($image))
        <img class="card-img-right flex-auto d-none d-md-block" src="{{asset("storage/{$image->path}")}}" alt="Card image cap">
    @endif
    </div>
</div>
