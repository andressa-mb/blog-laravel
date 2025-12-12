@extends('layouts.app')
@section('content')

<div class="row">
    <form action="" id="search-form" class="col-md-12">
        <select class="form-control" name="usersId" id="listUsers" onchange="this.form.submit()">
            <option value=""></option>
            @foreach ($bloggers as $blog_user)
                <option value="{{$blog_user->id}}" @if($request->usersId == $blog_user->id) selected @endif>
                    {{$blog_user->name}}
                </option>
            @endforeach
        </select>
    </form>
</div>

<div class="row">
    <div class="col-md-12 mt-5">
        <div class="row justify-content-center">
            @foreach($bloggers as $blog_user)
                <div class="card m-3 p-0 col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                    <div class="card-header m-0 p-2">
                        <h5 class="card-title">{{$blog_user->name}}</h5>
                    </div>
                    <div class="card-body p-2 d-flex justify-content-around">
                        @foreach ($blog_user->roles as $role)
                            <p>| {{$role->name}}</p>
                        @endforeach
                    </div>
                    <div class="card-footer m-0 p-2">
                        @if ($user->id !== $blog_user->id)
                            @if($user->isFollowing($blog_user))
                                <form action="{{route('unfollow-author', $blog_user)}}" method="POST" class="form-control">
                                    @csrf
                                    @method('DELETE')
                                    <div class="form-check">
                                        <input class="form-check-input" id="unfollow" onchange="this.form.submit()" type="checkbox" name="following"
                                            checked
                                        />
                                        <label for="unfollow" class="form-check-label">Não seguir</label>
                                    </div>
                                </form>
                            @else
                                <form action="{{route('follow-author', $blog_user)}}" method="POST" class="form-control">
                                    @csrf
                                    <div class="form-check">
                                        <input class="form-check-input" id="follow" onchange="this.form.submit()" type="checkbox" name="following"
                                        />
                                        <label for="follow" class="form-check-label">Seguir</label>
                                    </div>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
