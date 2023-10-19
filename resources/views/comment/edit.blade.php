@extends('layout')
@section('content')
<div class="alert-danger">
    @if ($errors->any())
      @foreach($errors->all() as $error)
      <ul>
        <li>{{$error}}</li>
      </ul>
      @endforeach
    @endif
  </div>
  <form action="/comment/update/{{$comment->id}}" method="POST">
      @csrf

      <input type="hidden" name="article_id" value="{{$comment->article_id}}">
      <div class="mb-3">
          <label for="exampleInputTitle" class="form-label">Title</label>
          <input type="text" class="form-control" id="exampleInputTitle" name="title" value="{{$comment->title}}">
      </div>

      <div class="mb-3">
        <label for="exampleInputText" class="form-label">Text</label>
        <input type="text" class="form-control" id="exampleInputText" name="text" value="{{$comment->text}}">
      </div>
    <button type="submit" class="btn btn-primary">Update comment</button>
  </form>
@endsection