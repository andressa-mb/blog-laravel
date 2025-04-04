@extends('layouts.app')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('categories.store')}}" method="POST">
                @csrf
                <div class="mb-3">
                  <label for="name" class="form-label">Nome da Categoria:</label>
                  <input type="text" class="form-control" name="name" id="title" aria-describedby="emailHelp" required>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </div>
</div>
@endsection
