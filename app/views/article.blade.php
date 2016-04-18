@extends('blog-post_layout')

@section('metadata')
	<title> {{$post->title}} | {{ trans('public.siteName') }} </title>
	<meta name="description" content="{{ strip_tags($post->first_par) }}"  />
	<meta name="keywords" content="@foreach ($keywords as $kw){{$kw->keyword }}, @endforeach" />
	<meta name="author" content="{{$post->username}}" />
	
       
	<meta property="og:url" content="{{'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']}}" />
    <meta property="og:title" content="{{ $post->title }}" />
	<meta property="og:description" content="{{ strip_tags($post->first_par) }}" />
	<meta property="og:type" content="article" />
	
	<script src='{{url()}}/js/article.js'  type='text/javascript' > </script>
@stop

@section('content')
		<!-- Title -->
        <h1>{{ $post->title }} </h1>

        <!-- Author -->
        <p class="lead">
             {{ trans('public.writer') }} <a href="{{url()}}/about">{{ $post->username }}</a>
        </p>

        <hr>

        <!-- Date/Time -->
         <p>
			<span class="glyphicon glyphicon-time"> </span> {{ trans('public.postTime') }}  {{ $post->created_at}} <i>{{ trans('public.lastMod') }} {{ $post->updated_at}}</i>
		 </p>

         <hr>
                 <!-- Post Content -->
                 <div> {{$post->text}} </div>
                 <hr>

             
		<!-- keywords -->
		<div class='well'>
			<h4> Kulcsszavak: </h4>
			@foreach ($keywords as $kw)
				<span class='label label-default'> {{ $kw->keyword }} </span>
			@endforeach
		</div>

                <!-- Social media things -->
                <div class="fb-like" data-href="{{ 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] }}" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>		
                <div class="fb-comments" data-href="{{ 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] }}" data-numposts="5"> </div>
                <br />

		<!-- comment list -->
                <hr>
		<h3> {{ trans('public.comments') }} </h3> 
		<hr />
		@foreach ($comments as $c)
		   <!-- new comment -->
          <div class="media">
                <a class="pull-left" href="#">
                   <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">
							{{ $c->writer }}
                           <small>{{ $c->created_at }}</small>
						   @if ( Cookie::get ( $c->cookie_name  )   )
								<div id='commentControll'>
									<span class='glyphicon glyphicon-pencil' title="{{ trans('public.comment-modify') }}" data-toggle='modal' data-target='#updateModal' onclick='update({{ json_encode($c) }})'> </span>
									<span class='glyphicon glyphicon-trash' title="{{ trans('public.delete-comment') }}" data-toggle='modal' data-target='#deleteModal' onclick='delComment({{ json_encode($c) }})'> </span>
								</div>
						   @endif
                     </h4>
                    {{ $c->text }}
                </div>
         </div>
		@endforeach
		
		@foreach ($errors->all() as $error)
		 <!-- Error window -->
		 <div class='modal fade'>
			 <div class='modal-dialog'>
					 <div class='alert alert-danger fade in'>
					    <b style='align: center'>{{ trans('login.error') }}</b> 
						<span class='close' data-dismiss='alert'> &times; </span> <!-- close button -->  <hr /> 
						{{ $error }} <br />
					</div>
			</div>
		</div>
	@endforeach
			
@stop