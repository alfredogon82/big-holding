@extends('default')

@section('content')

<div class="mb-3">
	{{ Form::label('Id:', 'Id:', ['class'=>'form-label']) }}
	{{ $task->id }} <br>
<div>
<div class="mb-3">
	{{ Form::label('Title:', 'Title:', ['class'=>'form-label']) }}
	{{ $task->title }} <br>
<div>
<div class="mb-3">
	{{ Form::label('Description:', 'Description:', ['class'=>'form-label']) }}
	{{ $task->description }} <br>
<div>


@stop