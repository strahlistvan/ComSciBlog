@extends('blog-home_layout')

@section('metadata')
	<title> {{trans('public.siteName')}} | {{ trans('public.motto') }} </title>
	<meta name='description' content="{{ trans('public.short-desc') }}" />
	<!--meta name='keywords' content="{{ trans('public.keywords-list') }}" /-->
        <meta property="og:url"  content="{{url()}}" />
        <meta property="og:type" content="website" />
	<meta property="og:title" content="{{trans('public.siteName')}} | {{ trans('public.motto') }}" />
	<meta property="og:description" content='{{ trans('public.short-desc') }}' />
	<!--meta property="og:locale" content="{{ Session::get('myLocale') }}" /-->
	<meta property="og:image" content="{{url()}}/img/com-sci-logo-1.png" />
        <!--meta property="og:image:secure_url" content="{{url()}}/img/com-sci-logo-1.png" /-->
	
@stop

@section('content')

	@foreach ($posts as $p)
	
		<!-- New blog post -->
         <h2>
            <a href="{{url() }}/article/{{ $p->post_id }}/{{ urlencode($p->title) }}" title="{{ trans('public.reading') }} '{{ $p->title }}' ">{{ $p->title }}</a>
         </h2>
          <p class="lead"> 
                   {{ trans('public.writer') }} <a href="{{url()}}/about">{{ $p->username }}</a>
           </p>
           <p>
				<span class="glyphicon glyphicon-time"> </span> {{ trans('public.postTime') }}  {{ $p->created_at}} <i>{{ trans('public.lastMod') }} {{ $p->updated_at}}</i>
		   </p>
			 
             <hr>
             <div>
					{{ $p->first_par }}
			</div>
             <a class="btn btn-primary" href="{{url()}}/article/{{ $p->post_id }}/{{ urlencode($p->title) }}" title="{{ trans('public.reading') }} '{{ $p->title }}' "> {{ trans('public.readMore') }} <span class="glyphicon glyphicon-chevron-right"></span></a>
	     <div style="display: none"> {{ $p->text }} </div>		
              <hr>
              
	@endforeach
@stop