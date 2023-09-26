@extends('layout')
@section('content')
<form action="/article" method="post">
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
        <label for="date">Date</label>
        <input type="date" class="form-control" name="date" id="date">
    </div>
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" name="title" id="title">
    </div>
    <div class="form-group">
        <label for="shortDesc">ShortDesc</label>
        <input type="text" class="form-control" name="shortDesc" id="shortDesc">
    </div>
    <div class="form-group">
        <label for="desc">Desc</label>
        <input type="text" class="form-control" name="desc" id="desc">
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
</form>
@endsection