@extends('layouts.app')
@section('content')
    <div class="">
        <h3>Imagens relacionados ao post</h3>
    </div>

    <div class="row">
        <div class="col-md-12">
            @component('layouts.components.modal', [
                'modal_id' => 'modal_images' ,
                'title' => "Adicione imagens ao post",
                'form_id' => "add_images",
            ])
                <form action="{{route('store-images', $post)}}" method="post" enctype="multipart/form-data" id="add_images">
                    @csrf
                    <div class="form-group">
                        <label for="image_file">Imagem</label>
                        <input type="file" class="form-control" id="image_file" name="image_file">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="description">Descrição da imagem:</label>
                        <input type="text" class="form-control" id="description" name="description">
                    </div>
                    <div>
                        <h3>Tipo de imagem</h3>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="typeImages" id="typeImage1" value="1" @if ($hasMain) disabled @endif checked>
                            <label class="form-check-label" for="typeImage1">
                                Principal do post
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="typeImages" id="typeImage2" value="2" @if ($hasMain) checked @endif>
                            <label class="form-check-label" for="typeImage2">
                                Outras do post
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="typeImages" id="typeImage3" value="3" @if ($hasThumb) disabled @endif>
                            <label class="form-check-label" for="typeImage3">
                                Thumb
                            </label>
                        </div>
                    </div>
                </form>
            @endcomponent

            <button type="button" class="btn btn-primary"
              data-toggle="modal" data-target="#modal_images">
                Add Imagens
            </button>

            <a href="{{route('web.posts.index')}}" class="btn btn-success">
                Finalizar cadastro
            </a>
        </div>
    </div>
@endsection

