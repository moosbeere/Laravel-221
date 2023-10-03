@extends('layout')
@section('content')
<div class="card mt-3" style="width: 100%;">
  <div class="card-body">
    <h5 class="card-title">{{$article->name}}</h5>
    <h6 class="card-subtitle mb-2 text-body-secondary">{{$article->short_desc}}</h6>
    <p class="card-text">{{$article->desc}}</p>
    <div class="flex">
      <a href="/article/{{$article->id}}/edit" class="btn btn-primary">Edit Article</a>
      <form action="/article/{{$article->id}}" method="post">
        @csrf
        @method("DELETE")
        <button type="submit" class="btn btn-secondary ml-1" >Delete</button>
      </form>
    </div>      
  </div>
</div>
<div class="card mt-2 mb-2">
  <div class="card-header text-center">
    <h3>Comments</h3>
  </div>
  <div class="card-body">
    <div class="form">
    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
        <ul>
            <li>{{$error}}</li>
        </ul>
        @endforeach
    </div>
    @endif
      <form action="/comment/store" method="post">
      @csrf
        <label class="form-label" for="title">Title</label>
        <input type="text" class="form-control" name="title" id="title">
        <label class="form-label" for="text">Text</label>
        <input type="text" class="form-control" name="text" id="text">
        <input type="hidden" name="article_id" value="{{$article->id}}">
    </div>  
  </div>
  <div class="card-footer text-center">
    <button type="submit" class="btn btn-primary">Save comment</button>
</form>
  </div>
</div>


@foreach($comments as $comment)
<div class="card mb-2" style="width: 100%;">
  <div class="card-body">
    <h5 class="card-title">{{$comment->title}}</h5>
    <h6 class="card-subtitle mb-2 text-body-secondary">{{$comment->text}}</h6>
    <div class="flex">
    <a href="/comment/edit/{{$comment->id}}" class="btn btn-primary mr-1">Edit comment</a>
    <a href="/comment/delete/{{$comment->id}}" class="btn btn-secondary">Delete comment</a>
</div>
</div>
</div>
@endforeach
{{$comments->links()}}
@endsection