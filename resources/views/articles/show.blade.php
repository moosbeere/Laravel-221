@extends('layout')
@section('content')
<div class="card" style="width: 68rem;">
  <div class="card-body">
    <h5 class="card-title">{{$article->name}}</h5>
    <h6 class="card-subtitle mb-2 text-body-secondary">{{$article->short_desc}}</h6>
    <p class="card-text">{{$article->desc}}</p>
    <a href="/article/{{$article->id}}/edit" class="card-link">Edit Article</a>
    <form action="/article/{{$article->id}}" method="post">
      @csrf
      @method("DELETE")
      <button type="submit">Delete</button>
    </form>
    
  </div>
</div>
@endsection