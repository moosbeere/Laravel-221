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
      <td><a href="/comment/accept" class="btn btn-secondary mb-2">Accept</a>
      <a href="/comment/reject" class="btn btn-danger">Reject</a></td>
    </tr>
  @endforeach
  </tbody>
</table>
@endsection