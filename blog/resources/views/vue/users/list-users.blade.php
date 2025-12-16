@extends('layouts.app')
@section('content')
    <div>
        <div class="row" id="vue-users">
            <nav class="col-2">
               <ul class="nav nav-tabs flex-column">
                   <li class="nav-item m-2 font-weight-bold border border-info border-top-0 rounded-bottom" style="font-size: 20px;">
                       <router-link to="/" class="text-dark pl-2 text-decoration-none">Usuários</router-link>
                   </li>
                   <li class="nav-item m-2 font-weight-bold border border-info border-top-0 rounded-bottom" style="font-size: 20px;">
                       <router-link to="/create-usuarios" class="text-dark pl-2 text-decoration-none">Criar Usuário</router-link>
                   </li>
               </ul>
           </nav>
           <div class="col-10">
               <router-view></router-view>
           </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{mix('js/users/app.js')}}"></script>
    @endpush

@endsection
