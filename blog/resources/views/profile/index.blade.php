@extends('layouts.app')
@section('content')
<div class="row">
    <form action="#" method="POST" class="col-md-12">
        @csrf
        <div class="mb-3">
          <label for="role" class="form-label">Perfil do usuário:</label>
          @foreach ($user->roles as $role)
            <input type="text" class="form-control @error('role') is-invalid @enderror" name="role" id="role" value="{{$role->name}}" disabled>
          @endforeach
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Nome:</label>
            <input type="text" class="form-control" name="user_id" id="name" value="{{$user->name}}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" aria-describedby="emailHelp" value="{{$user->email}}">
        </div>
        <button type="submit" class="btn btn-success">Atualizar</button>
    </form>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="following" class="form-label">Estou Seguindo:</label>
                @foreach ($user->followings as $following)
                    {{$user->countFollowings()}}
                   {{-- Conta os posts alerts <span>{{$user->countPostAlertsFrom($following->author)}}</span> --}}
                    @break
                @endforeach
                <button class="ml-2 btn btn-info" onclick="viewFollowings()">Ver</button>
            </div>
            <div id="followingDiv" class="followingDiv invisible">
                @foreach ($user->followings as $following)
                    <input type="text" class="form-control @error('followers') is-invalid @enderror" name="following" id="following" value="{{$following->followed->name}}">
                @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="followers" class="form-label">Meus Seguidores:</label>
                @foreach ($user->followers as $follower)
                    <span>{{$user->countFollowers()}}</span>
                    @break;
                @endforeach
                <button class="ml-2 btn btn-info" onclick="viewFollowers()">Ver</button>
            </div>
            <div id="followerDiv" class="followerDiv invisible">
                @foreach ($user->followers as $follower)
                    <input type="text" class="form-control @error('followers') is-invalid @enderror" name="followers" id="followers" value="{{$follower->follower->name}}">
                @endforeach
            </div>
        </div>

</div>
@endsection

<script>
    function viewFollowings(){
        var follow = document.getElementById('followingDiv');
        follow.classList.replace('invisible', 'visible');
    }

    function viewFollowers(){
        var follow = document.getElementById('followerDiv');
        follow.classList.replace('invisible', 'visible');
    }
</script>
