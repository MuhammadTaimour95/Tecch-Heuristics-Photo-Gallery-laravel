@extends('layouts.app')

@section('content')
{!!Form::open(['action' => 'AlbumsController@store' , 'method' => 'POST' , 'enctype' => 'multipart/form-data']) !!}
    {{Form::text('name', '', ['placeholder' => 'Album Name'])}}
    {{Form::textarea('description', '', ['placeholder' => 'Album Description'])}}
    {{Form::file('cover_image')}}
    {{Form::submit('submit')}}

{!! Form::close() !!}
@endsection