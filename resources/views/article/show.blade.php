@extends('layout')
@section('content')
<div class="text-center mt-3">
    <div class="card" style="width: 100%;">
    <div class="card-body">
      <h5 class="card-title">{{$article->title}}</h5>
      <h6 class="card-subtitle mb-2 text-muted">{{$article->shortDesc}}</h6>
      <p class="card-text">{{$article->text}}</p>
      @can('create')
      <div class="btn-group">
        <a href="/article/{{$article->id}}/edit" class="btn btn-primary mr-3">Update article</a>
        <form action="/article/{{$article->id}}" method="post">
            @method('DELETE')
            @csrf
        <button type="submit" class="btn btn-danger">Delete Article</button>
        </form>
      </div>
      @endcan
      
    </div>
  </div>
  <h3 class="mt-3">Comments</h3>
  @isset($_GET['res'])
  @if ($_GET['res'] == 1)
  <div class="alert alert-success" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
    Your comment send to moderation!

  </div>
  @endif
  @endisset
  </div>
  
  <div class="alert-danger">
    @if ($errors->any())
      @foreach($errors->all() as $error)
      <ul>
        <li>{{$error}}</li>
      </ul>
      @endforeach
    @endif
  </div>
  <form action="/comment" method="POST">
      @csrf
      <div class="mb-3">
          <label for="exampleInputTitle" class="form-label">Title</label>
          <input type="text" class="form-control" id="exampleInputTitle" name="title">
      </div>
      <div class="mb-3">
        <label for="exampleInputText" class="form-label">Text</label>
        <input type="text" class="form-control" id="exampleInputText" name="text">
      </div>
      <div class="mb-3">
        <input type="hidden" name="article_id" value="{{$article->id}}">
      </div>
    <button type="submit" class="btn btn-primary">Add comment</button>
  </form>
  @foreach($comments as $comment)
  <div class="card mt-3" style="width: 50%;">
    <div class="card-body">
      <h5 class="card-title">{{$comment->title}}</h5>
      <p class="card-text">{{$comment->text}}</p>
      @can('comment', $comment)
      <div class="btn-group">
        <a href="/comment/edit/{{$comment->id}}" class="btn btn-primary mr-3">Update comment</a>
        <a href="/comment/delete/{{$comment->id}}" class="btn btn-primary mr-3">Delete comment</a>
      </div>
      @endcan
     </div>
  </div>
  @endforeach

@endsection