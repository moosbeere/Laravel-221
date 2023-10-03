@extends('layout')
@section('content')
<form action="/comment/update/{{$comment->id}}" method="post">
    @csrf
    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
        <ul>
            <li>{{$error}}</li>
        </ul>
        @endforeach
    </div>
    @endif
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" name="title" id="title" value="{{$comment->title}}">
    </div>
    <div class="form-group">
        <label for="text">Text</label>
        <input type="text" class="form-control" name="text" id="text" value="{{$comment->text}}">
    </div>
    
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection