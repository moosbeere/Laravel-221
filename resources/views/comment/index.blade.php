@extends('layout')
@section('content')
    <table class="table">
  <thead>
    <tr>
      <th scope="col">Date</th>      
      <th scope="col">Article Title</th>
      <th scope="col">Text</th>
      <th scope="col">Author</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    @foreach($comments as $comment)
    <tr>
      <th scope="row">{{$comment->created_at}}</th>
      @foreach ($articles as $article)
      @if($comment->article_id == $article->id)      
        <td>{{$article->title}}</a></td>
      @endif
      @endforeach
      <td>{{$comment->text}}</td>
      <td>{{$comment->getUserId()->name}}</td>
      <td>
        @if (!$comment->accept == 1)
        <a href="/comment/accept/{{$comment->id}}" class="btn btn-secondary">Accept</a>
        @else
        <a href="/comment/reject/{{$comment->id}}" class="btn btn-danger">Reject</a>
        @endif
      </td>
    </tr>
    @endforeach    
  </tbody>
</table>
{{$comments->links()}}
@endsection