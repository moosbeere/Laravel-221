@extends('layout')
@section('content')
   <p> Name University: {{ $data['name'] }} </p>
   <p> Address: {{ $data['adress'] }} </p>
   <p> Phone: {{$data['phone']}}</p>
@endsection