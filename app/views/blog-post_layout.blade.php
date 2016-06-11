<!DOCTYPE html>
<html lang="{{ Session::get('myLocale') }}">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">
    <link rel="icon" href="{{url()}}/favicon.png" type="image/png"/>
    <link rel="shortcut icon"  href="{{url()}}/favicon.png" type="image/png"/>
	
    @yield ('metadata')
    <meta property="fb:app_id" content="1440329686275570" />
    <!--meta property="og:type" content="website"-->
    <!-- Bootstrap Core CSS -->
    <link href="{{url()}}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Custom CSS -->
    <link href="{{url()}}/css/blog-post.css" rel="stylesheet" type="text/css" />
	
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

	@include('navbar')
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8">

                <!-- Blog Post -->
				@yield('content')
				
                <!-- Comments Form -->
                <div class="well">
                    <h4>{{ trans('public.leave-comment') }}</h4>
	
					<p> {{ trans('public.latex') }} </p>
					
                     {{ Form::open( array('name' => 'commentForm', 'id' => 'commentForm', 'action' => 'CommentController@postComment' ) ) }}
                        <div class="form-group" >
							<div class='input-group' style='margin-bottom: 10px'>
								<span class='input-group-addon' > 
									<label for='name'> {{ trans('login.your_un') }}  </label>
								</span>
								<input type='text' class='form-control'  name='name' id='name' placeholder="{{ trans('login.un_placeholder') }}" maxlength='100' required='required'   />
							</div>
							<textarea name='text' id='text' class="form-control" rows="5" style="resize: none;" required ></textarea>
							<input type='hidden' name='postID' value='{{$id}}' />
						</div>
							
						<!-- Captcha and submit button-->
						<div class='row'>
							<div class='col-lg-6'>
								<div id='recaptcha1'></div>
							</div>
							<div class='col-lg-6'> 
								<button type='submit' class="btn btn-primary" id='commentButton' >Submit</button>
							</div>
						</div>
                {{ Form::close() }}
                </div>
            </div>
			
		<!-- Update Modal -->
		<div id="updateModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"> Hozzászólás módosítása</h4>
			  </div>
			  <div class="modal-body">

			   {{ Form::open( array('name' => 'updateCommentForm', 'action' => 'CommentController@updateComment' ) ) }}
				<div class="form-group" >
					<div class='input-group' style='margin-bottom: 10px'>
						<span class='input-group-addon' > 
							<label for='updateName'> 
								{{ trans('login.your_un') }}  </label>
						</span>
						<input type='text' class='form-control'  name='updateName' id='updateName' placeholder="{{ trans('login.un_placeholder') }}" maxlength='100' required='required'   />
				</div>
				<textarea name='updateText' id='updateText' class="form-control" rows="5" style="resize: none;" required="required" > </textarea>
				<input type='hidden' name='updatePostID' value='{{$id}}' />
				</div>
									
				<!-- Captcha and submit button-->
				<div class='row'>
					<div class='col-lg-6'>
						<div id='recaptcha2' ></div>
					</div>
					<div class='col-lg-6'> 
						<button type='submit' class="btn btn-primary" id='updateCommentButton' >Submit</button>
					</div>
				</div>
				{{ Form::close() }}
			  </div> <!--body-->
			</div> <!-- modal content-->

		  </div>
		</div>	 <!-- update modal end -->
			
		<!-- Delete modal-->
		<div class="modal fade" id="deleteModal" role="dialog" >
			<div class="modal-dialog">
			  <div class="modal-content panel-danger">
				<div class="modal-header panel-heading">
				  <button type="button" class="close" data-dismiss="modal" >&times;</button>
				   <b> <span class='glyphicon glyphicon-trash'> </span> &nbsp; {{ trans('admin-ui.delete-post') }} </b>
				</div>
				<div class="modal-body panel-body">
					<p> {{ trans('admin-ui.really-delete') }} </p>	
				</div>
				<div class="modal-footer">
					{{ Form::open( array('action' => 'CommentController@deleteComment', 'id' => 'delForm') ) }}
						<input type='hidden' name='delCommentID' id='delCommentID' value='' />
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-danger" name='delOK' id='delOK'  >Save changes</button>
					{{ Form::close() }}
				</div>
			  </div><!-- modal-content -->
			</div><!-- modal-dialog -->
		</div><!-- modal -->
			
		<!--div--> <!-- row end-->
		<!-- SIDEBAR -->
		@include('sidebar')
        <hr>

        <!-- Footer -->
        <footer>
			<!-- hood.hu eu cookie / eleje -->
			<script async src="//hood.hu/cookie.js" data-title="Ez a weboldal sütiket (cookie-kat) használ a jobb felhasználói élmény érdekében." data-moretext="Részletek..." data-morelink="{{url()}}/privacy" data-oktext="Rendben!" data-ver="1" id="hood-proposer"></script>
			<!-- hood.hu eu cookie / vége -->

            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; {{ trans('public.owner') }} {{ date('Y')  }}</p>
                    <p> {{ trans('public.thanks-post') }} </p>
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
    <script src="https://www.google.com/recaptcha/api.js?onload=myCallBack&amp;render=explicit" async defer></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{url()}}/js/bootstrap.min.js"></script>

	<!-- MathJAX -->
	<script type="text/javascript"
  src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
	</script>
	<script type="text/x-mathjax-config">
		MathJax.Hub.Config({
		  tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
		});
	</script>
	
	
	<!-- Syntax highlighter -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/styles/default.min.css"  rel="stylesheet"  type="text/css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/highlight.min.js"></script>
	<script>hljs.initHighlightingOnLoad();</script>
	<script src="{{url() }}/js/search.js" > </script>
</body>

</html>
	