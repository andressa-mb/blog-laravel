@extends('layouts.app')

@auth
@section('li-bem-vindo')
<h5 style="margin: 8px;">{{__('messages.bem-vindo', ['name' => $user->name])}}</h5>
@endsection
@endauth

@section('content')

<div class="m-auto w-50 mt-4">
    <div class="text-center" style="font-size: 28px">
        BLOG
    </div>

    <div>
       <p>Texto qualquer de introdução</p>
       @php($minutes = 5)
       {{trans_choice('messages.minutes_ago', $minutes, ['value' => $minutes])}}
    </div>


</div>
@endsection
