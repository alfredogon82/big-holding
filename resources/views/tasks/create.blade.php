@extends('default')

@section('content')

	@if($errors->any())
		<div class="alert alert-danger">
			@foreach ($errors->all() as $error)
				{{ $error }} <br>
			@endforeach
		</div>
	@endif

	{!! Form::open(['route' => 'tasks.store']) !!}

		<div class="mb-3">
			{{ Form::label('title', 'Title', ['class'=>'form-label']) }}
			{{ Form::input('title', 'title', null, array('class' => 'form-control')) }}
		</div>
		<div class="mb-3">
			{{ Form::label('description', 'Description', ['class'=>'form-label']) }}
			{{ Form::textarea('description', null, array('class' => 'form-control')) }}
		</div>
		<div class="mb-3">
			{{ Form::label('started_at', 'Starts in', ['class'=>'form-label']) }}
			{{ Form::date('started_at', 'null', ['class' => 'form-control']) }}
		</div>
		<div class="mb-3">
			{{ Form::label('ended_at', 'Ends in', ['class'=>'form-label']) }}
			{{ Form::date('ended_at', 'null', ['class' => 'form-control']) }}
		</div>
			{{ Form::hidden('user_id', $user_id) }}
		<div class="mb-3">
			{{ Form::label('is_done', 'Status', ['class'=>'form-label']) }}
			@php 
			$listOfOptions = [
				'1' => 'Pending',
				'2' => 'In Progress',
				'3' => 'Completed',
			];
			@endphp
			{{ Form::select('is_done', $listOfOptions, null, ['class' => 'form-label'], ['class' => 'form-control']) }}
		</div>

		{{ Form::submit('Create', array('class' => 'btn btn-primary')) }}

	{{ Form::close() }}


@stop