@extends('layout')
@section('content')
<form action="/comment/update/{{$comment->id}}" method="POST">
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
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="{{$comment->title}}">
    </div>
    <div class="mb-3">
        <label for="text" class="form-label">Text</label>
        <input type="text" class="form-control" name="text" id="text" value="{{$comment->text}}">
    </div>
    <input type="hidden" name="article_id" value="{{$comment->article_id}}">
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection