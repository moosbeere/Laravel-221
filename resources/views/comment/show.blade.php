@extends('layout')
@section('content')
<div class="text-center">
    <div class="card" style="width: 100%;">
    <div class="card-body">
      <h5 class="card-title">{{$article->title}}</h5>
      <h6 class="card-subtitle mb-2 text-muted">{{$article->shortDesc}}</h6>
      <p class="card-text">{{$article->text}}</p>
      <div class="btn-group">
        <a href="/article/{{$article->id}}/edit" class="btn btn-primary mr-3">Update article</a>
        <form action="/article/{{$article->id}}" method="post">
            @method('DELETE')
            @csrf
        <button type="submit" class="btn btn-danger">Delete Article</button>
        </form>
      </div>
      
    </div>
  </div>
</div>

@endsection