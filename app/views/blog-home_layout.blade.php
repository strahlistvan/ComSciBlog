<!DOCTYPE html>
<html lang="{{ Session::get('myLocale') }}" prefix="og: http://ogp.me/ns#" >

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	@yield('metadata')
	
	<meta property="fb:app_id" content="1440329686275570" />
	 <meta name="robots" content="index, follow">
	<link rel="icon" href="{{url()}}/favicon.png" type="image/png"/>
	<link rel="shortcut icon"  href="{{url()}}/favicon.png" type="image/png"/>
	
    <!-- Bootstrap Core CSS -->
    <link href="{{url()}}/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="{{url()}}/css/blog-home.css" rel="stylesheet" />
	<!-- Syntex Highlight.js -->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/styles/default.min.css" />
	
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-66457680-1', 'auto');
  ga('send', 'pageview');

</script>
<meta name="alexaVerifyID" content="FzR2aoK9hfQR-yXtr4F1XZuSztk"/>

</head>

<body>

<div id="fb-root"></div>

    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '1440329686275570',
          xfbml      : true,
          version    : 'v2.4'
        });
      };
      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/hu_HU/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
    </script>

    @include ('navbar')

    <!-- Page Content -->
    <div class="container">

		<div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    {{ trans('public.siteName') }} <br />
                    <small> {{ trans('public.motto') }} </small>
                </h1>

				@yield('content')
				
                <!-- Pager -->
                <ul class="pager">
					@if (!$isLastPage)
						<li class="previous">
							@if (!isset($usedKeyword))
								<a href="{{url()}}/page/{{$pageNum+1 }}">&larr; {{ trans('public.older') }}</a>
							@else
								<a href="{{ url().'/keyword/'.urlencode($usedKeyword).'/'.($pageNum+1) }}">&larr; {{ trans('public.older') }}</a>
							@endif
						</li>
					@endif
						
					@if ($pageNum!= 1)
						<li class="next">
							@if (!isset($usedKeyword))
								<a href="{{url()}}/page/{{$pageNum-1 }}">&rarr; {{ trans('public.newer') }}</a>
							@else
								<a href="{{url().'/keyword/'.urlencode($usedKeyword).'/'.($pageNum-1) }}">&rarr; {{ trans('public.newer') }}</a>
							@endif
						</li>
					@endif
                </ul>

            </div>
			<!-- SIDEBAR -->
			@include('sidebar')
			<hr>
		</div>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; {{ trans('public.owner') }} {{ date('Y')  }}</p>
                    <p> {{ trans('public.thanks-home') }} </p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </footer>
		@include('search-modal')
    </div>
    <!-- /.container -->
	
	<!-- hood.hu eu cookie / eleje -->
	<script async src="//hood.hu/cookie.js" data-title="{{ trans('public.cookie-info') }}" data-moretext="{{ trans('public.details') }}..." data-morelink="{{url()}}/privacy" data-oktext="{{ trans('public.accept') }}" data-ver="1" id="hood-proposer"></script>
	<!-- hood.hu eu cookie / vége -->

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!--script src="{{url() }}/js/jquery.min.js"></script-->
    <!-- Bootstrap Core JavaScript -->
    <script src="{{url()}}/js/bootstrap.min.js"> </script>
	
	<!-- MathJAX -->
	<script type="text/javascript"
  src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
	</script>
	<script type="text/x-mathjax-config">
		MathJax.Hub.Config({
		  tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
		});
	</script>
	
	<!-- Syntax Highlight.js -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/highlight.min.js"></script>
	
	<script src="{{url() }}/js/search.js" > </script>
</body>

</html>
