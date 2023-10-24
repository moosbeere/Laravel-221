@extends('layout')
@section('content')
<table class="table">
  <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">Title</th>
      <th scope="col">Text</th>
      <th scope="col">Author</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  @foreach($comments as $comment)
    <tr>
      <th scope="row">{{$comment->created_at}}</th>
      <td>{{$comment->title}}</td>
      <td>{{$comment->text}}</td>
      <td>@if($comment->author_id === NULL)
        no name
        @else {{$comment->getAuthor()->name}}
       @endif
      </td>
      <td>
      @if(!$comment->accept)  
      <a href="/comment/accept/{{$comment->id}}" class="btn btn-secondary mb-2">Accept</a>
      @endif
      <a href="/comment/reject/{{$comment->id}}" class="btn btn-danger">Reject</a></td>
    </tr>
  @endforeach
  </tbody>
</table>
{{$comments->links()}}
@endsection