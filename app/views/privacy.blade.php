@extends('simple_layout')

@section('metadata')
	<title> {{ trans('public.privacy') }} | {{ trans('public.siteName') }} </title>
	<meta name="description" content="{{ trans('public.about_me_text') }}"  />
	<meta name="author" content="István" />
       
	<meta property="og:url" content="{{'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']}}" />
    <meta property="og:title" content=" {{ trans('about') }} | {{ trans('public.siteName') }} " />
	<meta property="og:description" content="{{ trans('public.about_desc') }} " />
	<meta property="og:type" content="website" />
	
@stop

@section('content')

<h3> {{ trans("public.privacy") }} </h3>
<p> {{  trans("public.privacy-text") }} </p>
<img class="img img-responsive" src="{{url()}}/img/Mycookie.jpg"  alt="{{ trans('public.cookie-joke') }}" />  
<small>  {{ trans('public.cookie-joke') }}</small>

@stop