@extends('layouts.app')
@section('content')

<div class="row">
    <form action="" id="listUsersName" class="col-md-12">
        <label for="name" class="form-label">{{__('messages.buscar_usuario')}}</label>
        <input type="text" class="form-control" name="userName" id="listUsersName" onchange="this.form.submit()">
    </form>
</div>

<div class="row">
    <div class="col-md-12 mt-5">
        <div class="row justify-content-center">
            @foreach($bloggers as $blogUser)
                <div class="card m-3 p-0 col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                    <div class="card-header m-0 p-2">
                        <h5 class="card-title text-center">
                            <a href="{{route('web.users.show', $blogUser->id)}}" class="text-dark text-decoration-none">{{$blogUser->name}}</a>
                        </h5>
                    </div>
                    <div class="card-body d-flex justify-content-around">
                        @foreach ($blogUser->roles as $role)
                            <p class="p-2 m-0 badge badge-primary">{{$role->name}}</p>
                        @endforeach
                    </div>
                    @auth
                        @if($user->is_admin)
                            <div class="card-body">
                                <button type="button" class="btn btn-sm btn-warning"
                                    data-toggle="modal" data-target="#modal_edit_user_{{$blogUser->id}}">{{__('messages.editar')}}</button>

                                <button type="button" class="btn btn-sm btn-danger"
                                    data-toggle="modal" data-target="#modal_delete_user_{{$blogUser->id}}">
                                        {{__('messages.excluir')}}
                                </button>
                            </div>
                        @endif
                        <div class="card-footer d-flex justify-content-around align-items-center">
                            @if ($user->id !== $blogUser->id)
                                @if($user->isFollowing($blogUser))
                                    <form action="{{route('unfollow-author', $blogUser)}}" method="POST" class="border border-dark rounded m-3 p-2">
                                        @csrf
                                        @method('DELETE')
                                        <div class="form-check">
                                            <input class="form-check-input" id="unfollow-{{$blogUser->id}}" onchange="this.form.submit()" type="checkbox" name="following"
                                                checked
                                            />
                                            <label for="unfollow-{{$blogUser->id}}" class="form-check-label">{{__('messages.nao_seguir')}}</label>
                                        </div>
                                    </form>
                                @else
                                    <form action="{{route('follow-author', $blogUser)}}" method="POST" class="border border-dark rounded m-3 p-2">
                                        @csrf
                                        <div class="form-check">
                                            <input class="form-check-input" id="follow-{{$blogUser->id}}" onchange="this.form.submit()" type="checkbox" name="following"
                                            />
                                            <label for="follow-{{$blogUser->id}}" class="form-check-label">{{__('messages.seguir')}}</label>
                                        </div>
                                    </form>
                                @endif
                            @endif
                            <div class="">
                                <a href="{{route('web.users.show', $blogUser->id)}}" class="btn btn-info">{{__('messages.ver_perfil')}}</a>
                            </div>
                        </div>
                    @endauth
                </div>

                @component('layouts.components.modal', [
                    'modal_id' => 'modal_edit_user_' . $blogUser->id,
                    'title' => __('messages.editar-usuario').'?',
                    'classBtn' => 'btn btn-success',
                    'form_id' => 'confirm-edit-user-' . $blogUser->id,
                    'btnText' =>  __('messages.atualizar'),
                ])

                    <form action="{{route('web.users.update', [$blogUser->id])}}" method="POST" id="confirm-edit-user-{{$blogUser->id}}">
                        @csrf
                        @method('PUT')
                        <div class="">
                            <label for="name" class="form-label">{{__('messages.nome')}}</label>
                            <input type="text" value="{{$blogUser->name}}" id="name" name="name" class="form-control" required>
                        </div>
                        <div>
                            <label for="email" class="form-label">{{__('messages.email')}}</label>
                            <input type="text" value="{{$blogUser->email}}" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="mt-2">
                            <h5>{{__('messages.perfil_usuario')}}</h5>
                            @foreach (App\Models\Role::get() as $role)
                                @php
                                    $userRoles = $blogUser->roleIdsFromUser();
                                    $checked = in_array($role->id, $userRoles)
                                @endphp
                                <div class="form-group form-check flex-row">
                                    <input type="checkbox" class="form-check-input" id="user-role-{{$role->id}}" value="{{$role->id}}" name="roles[]" {{ $checked ? 'checked' : '' }}>
                                    <label for="user-role-{{$role->id}}" class="form-check-label">{{$role->name}}</label>
                                </div>
                            @endforeach
                        </div>
                    </form>
                @endcomponent

                @component('layouts.components.modal', [
                    'modal_id' => 'modal_delete_user_'.$blogUser->id,
                    'title' => __('messages.excluir-usuario').'?',
                    'classBtn' => 'btn btn-danger',
                    'form_id' => 'confirm-delete-user-'.$blogUser->id,
                    'btnText' => __('messages.excluir'),
                ])

                    <form action="{{route('web.users.destroy', [$blogUser])}}" method="POST" id="confirm-delete-user-{{$blogUser->id}}">
                        @csrf
                        @method('DELETE')
                        <p>{{__('text.confirma_exclusao_usuario')}}</p>
                    </form>
                @endcomponent
            @endforeach
        </div>
    </div>
</div>
@endsection
