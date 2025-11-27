<form action="{{$action}}" method="POST" enctype="multipart/form-data">
    @csrf
        {{$slot}}
        <button type="submit" class="btn btn-success">{{$btnText}}</button>
</form>


