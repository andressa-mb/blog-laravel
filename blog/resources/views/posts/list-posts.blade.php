@extends('layouts.app')
@section('content')
    <div>
        <div class="row" id="vue-posts">
            <nav class="col-2">
                <h5 class="text-center">MENU POSTS</h5>
               <ul class="nav nav-tabs flex-column">
                @if($user->is_admin)
                   <li class="nav-item m-2 font-weight-bold border border-info border-top-0 rounded-bottom" style="font-size: 20px;">
                       <router-link to="/" class="text-dark pl-2 text-decoration-none">Posts</router-link>
                   </li>
                @endif
                   <li class="nav-item m-2 font-weight-bold border border-info border-top-0 rounded-bottom" style="font-size: 20px;">
                       <router-link to="/my-posts" class="text-dark pl-2 text-decoration-none">Meus Posts</router-link>
                   </li>
                   <li class="nav-item m-2 font-weight-bold border border-info border-top-0 rounded-bottom" style="font-size: 20px;">
                       <router-link  :to="{ name: 'create-post', params: { id: {{ $user->id }} } }" class="text-dark pl-2 text-decoration-none">Novo</router-link>
                   </li>
               </ul>
           </nav>
           <div class="col-10">
               <router-view></router-view>
           </div>
        </div>
    </div>

@push('scripts')
    <script src="{{mix('js/posts/app.js')}}"></script>
@endpush

@endsection
