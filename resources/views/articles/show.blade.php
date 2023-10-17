@extends('layout')
@section('content')
<div class="container">
<div class="card" style="width: 100%;">
  <div class="card-body">
    <h5 class="card-title">{{$article->name}}</h5>
    <h6 class="card-subtitle mb-2 text-body-secondary">{{$article->short_desc}}</h6>
    <p class="card-text">{{$article->desc}}</p>
    @can('update', $article)
    <div class="d-inline-flex gap-1">
        <a href="/article/{{$article->id}}/edit" class="btn btn-primary mr-3">Update article</a>
        <form action="/article/{{$article->id}}" method="post">
            @method('DELETE')
            @csrf
            <button class="btn btn-danger" type="submit">Delete</button>
        </form>
    </div>
    @endcan
  </div>
</div>

<div class="card text-center"> 
@if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <ul>
                    <li>
                        {{$error}}
                    </li>
                </ul>
            @endforeach
        </div>
    @endif
  <div class="card-header">
    <h3>Comments</h3>
  </div>
  <div class="card-body">
      <form action="/comment/store" method="post">
        @csrf
    <div class="mb-3">
      <label for="title" class="form-label">Title comment</label>
      <input type="text" name="title" id="" class="form-control">
    </div>
    <div class="mb-3">
      <label for="text" class="form-label">Comment</label>
      <input type="text" name="text" id="" class="form-control">
    </div>
    <input type="hidden" name="article_id" value="{{$article->id}}">
  </div>
  <div class="card-footer text-body-secondary">
    <button class="btn btn-primary" type="submit">Save</button>
  </form>
</div>
</div>

@foreach($comments as $comment)
<div class="card" style="width: 100%;">
  <div class="card-body">
    <h5 class="card-title">{{$comment->title}}</h5>
    <h6 class="card-subtitle mb-2 text-body-secondary">{{$comment->text}}</h6>
    @can('comment', $comment)
    <div class="d-inline-flex gap-1">
        <a href="/comment/edit/{{$comment->id}}" class="btn btn-primary">Update comment</a>
        <a href="/comment/delete/{{$comment->id}}" class="btn btn-secondary">Delete comment</a>
    </div>
    @endcan
  </div>
</div>
@endforeach
{{$comments->links()}}
</div>
@endsection