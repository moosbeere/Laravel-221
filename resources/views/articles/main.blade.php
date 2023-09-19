@extends('layout')
@section('content')
<table class="table">
  <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">Name</th>
      <th scope="col">ShortDesc</th>
      <th scope="col">Desc</th>
    </tr>
  </thead>
  <tbody>
  @foreach($articles as $article)
    <tr>
      <th scope="row">{{$article->date}}</th>
      <td><a href="/article/show/{{$article->id}}"></a>{{$article->name}}</td>
      <td>{{$article->shortDesc}}</td>
      <td>{{$article->desc}}</td>
    </tr>
  @endforeach
  </tbody>
</table>
@endsection