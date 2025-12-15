@extends('layouts.app')

@section('content')
<div>
    <p>não lembro se ta sendo usado, acho q não, depois verificar</p>
    <p>teste com componente, vai aparecer?</p>
</div>
<div>
    <app-component></app-component>

</div>

<script src="{{mix('js/users/app.js')}}">

</script>

@endsection
