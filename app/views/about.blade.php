@extends('simple_layout')

@section('metadata')
	<title> {{ trans('public.about') }} | {{ trans('public.siteName') }} </title>
	<meta name="description" content="{{ trans('public.about_me_text') }}"  />
	<meta name="author" content="István" />
       
	<meta property="og:url" content="{{'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']}}" />
    <meta property="og:title" content=" {{ trans('about') }} | {{ trans('public.siteName') }} " />
	<meta property="og:description" content="{{ trans('public.about_desc') }} " />
	<meta property="og:type" content="website" />
	
	<!--script src='{{url()}}/js/article.js'  type='text/javascript' > </script-->
@stop

@section('content')
		<!-- Title -->
        <h1>  {{ trans('public.about') }} </h1>

        <p> {{ trans('public.about_me_text') }} </p>
		
		<h1> {{ trans('public.about_blog') }} </h1>
		
		<p> {{ trans('public.about_blog_text') }}  </p>

                <!-- Social media things -->
                <div class="fb-like" data-href="{{ 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] }}" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>		
                <div class="fb-comments" data-href="{{ 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] }}" data-numposts="5"> </div>
                <br />
			
@stop