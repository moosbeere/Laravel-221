@extends('layout')
@section('content')
<form action="/registr" method="post">
    @csrf
    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
        <ul>
            <li>{{$error}}</li>
        </ul>
        @endforeach
    </div>    
    @endif
<div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" name="name" id="name">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" name="password" id="exampleInputPassword1">
  </div>
  <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection