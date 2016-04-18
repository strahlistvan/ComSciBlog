@extends('default_layout')

@section('metadata')
	<title> {{ trans('login.loginTitle') }} | CompSci blog </title>
@stop

@section('content')
  <h1>{{ trans('login.loginTitle2') }} </h1>
  
   <div class='form-group'>
   {{ Form::open( array('action' => 'LoginController@postLogin'  ) ) }}
		<div class='input-group'>
			<span class='input-group-addon'> {{ Form::label('username', trans('login.your_un') ) }} </span>
			{{ Form::text('username', null, array('placeholder' => trans('login.un_placeholder'), 'required' => 'required', 'class' => 'form-control' ) ) }} <br />
		</div>
		<div style='margin: 10px'> </div>
		<div class='input-group'>
			<span class='input-group-addon' > {{ Form::label('password', trans('login.your_pw') ) }} </span>
			{{ Form::password('password', array('placeholder' => trans('login.pw_placeholder'), 'required' => 'required', 'class' => 'form-control' ) ) }} <br />
		</div>
		<div style='margin: 10px'> </div>
		<div class='input-group'>
			{{ Form::submit( trans('login.sub_button'), array('name' => 'ok', 'class' => 'btn  btn-lg btn-primary', 'title' => trans('login.sub_button') )) }}
		</div>
   {{Form::close()}}
   </div>
   	@foreach ($errors->all() as $error)
		 <!-- Error window -->
	     <div class='alert alert-danger fade in'>
			<span class='close' data-dismiss='alert'> &times; </span> <!-- close button -->
			<b>{{ trans('login.error') }}</b> {{ $error }} <br />
			<i> {{ trans('login.note') }} </i> <br />
		</div>
	@endforeach
   
@stop