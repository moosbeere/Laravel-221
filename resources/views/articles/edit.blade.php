@extends('layout')
@section('content')
<form action="/article/{{$article->id}}" method="POST">
@method('PUT')
    @csrf
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

    <div class="mb-3">
        <label for="date" class="form-label">Date</label>
        <input type="date" class="form-control" id="date" name="date" value="{{$article->date}}">
    </div>
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="{{$article->name}}">
    </div>
    <div class="mb-3">
        <label for="shortDesc" class="form-label">ShortDesc</label>
        <input type="text" class="form-control" name="shortDesc" id="shortDesc" value="{{$article->short_desc}}">
    </div>
    <div class="mb-3">
        <label for="desc" class="form-label">Description</label>
        <input type="text" class="form-control" name="desc" id="desc" value="{{$article->desc}}">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection