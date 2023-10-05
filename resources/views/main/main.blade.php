@extends('layout')
@section('content')
    <!-- <h3>Hello, Laravel!</h3> -->
    <table class="table">
  <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">Name</th>
      <th scope="col">ShortDesc</th>
      <th scope="col">Desc</th>
      <th scope="col">Image</th>
    </tr>
  </thead>
  <tbody>
    @foreach($articles as $article)
    <tr>
      <th scope="row">{{$article->date}}</th>
      <td>{{$article->name}}</td>
      <td>{{$article->shortDesc}}</td>
      <td>{{$article->desc}}</td>
      <td><a href="/galery/{{$article->full_image}}"><img src="{{URL::asset($article->preview_image)}}" alt="" width="80" height="80"></a></td>      
    </tr>
    @endforeach    
  </tbody>
</table>
@endsection