  <!-- Fixed navbar -->
		<nav class="navbar navbar-inverse navbar-fixed-top">
		  <div class="container">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="{{ url() }}/" }} > {{ trans('public.siteName') }} </a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
			
				<!-- main buttons -->
				<ul class="nav navbar-nav">
					<li> <a href='{{ url() }}/' > <span class='glyphicon glyphicon-star'> </span> &nbsp; {{ trans('public.mainPage') }} </a> </li>
					<li> <a href='{{ url() }}/about' > <span class='glyphicon glyphicon-star-empty'> </span> &nbsp; {{ trans('public.about') }} </a> </li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" >  <span class='glyphicon glyphicon-tags'> </span> &nbsp; {{ trans('public.categories') }} <span class="caret"></span></a>
						
						<ul class="dropdown-menu"> <!-- category dropdown -->
							  @foreach ($categories as $cat)
									<li> <a href='{{ url()."/category/".urlencode($cat->category_name) }}'> {{ $cat->category_name }} </a> </li>
									<li role="separator" class="divider"></li>
							  @endforeach
						</ul>
					
					@if (Session::has('userName'))
						<li ><a href="{{ url() }}/logout"> <span class='glyphicon glyphicon-user'> </span> &nbsp; {{ trans('public.logout') }} : {{ Session::get('userName') }}</a></li>
						<li> <a href='{{ url() }}/private'> <span class='glyphicon glyphicon-pencil'> </span> &nbsp;{{ trans('public.adminUI') }} </a> </li>
					@else 
						<!-- li><a href="{{ url() }}/login">  <span class='glyphicon glyphicon-user'> </span> &nbsp; {{ trans('public.login') }} </a></li -->
					@endif

					
				</ul> <!-- main buttons end -->
				  
				<ul class="navbar-form navbar-right"> <!--search-->
					<div class="form-group">
						<input id='search-text-nav' type="text" class="form-control" placeholder="{{ trans('public.search') }}..." required >
					</div>         
                    <button id='search-button-nav' class="btn btn-inverse" type="button" title="{{ trans('public.search') }}">
                         <span class="glyphicon glyphicon-search"> </span>
                    </button>
				</ul>
				  
				<!-- language picker -->
				<ul class="nav navbar-nav navbar-right"> 
					<li {{ (Session::get('myLocale')=='hu')?"class=active":""}} >
						<a href="{{ url() }}/hu"> <div title="{{ trans('public.switchHun') }}"  style="width: 35px; height: 20px; background-image: url('{{url()}}/img/hungarian.jpg'); background-size: 35px 20px;"> </div> </a>
					</li>
						
					<li {{ (Session::get('myLocale')=='en')?"class=active":""}}>
						<a href="{{ url() }}/en"> <div title="{{ trans('public.switchEng') }}" style="width: 35px; height: 20px;  background-image: url('{{url()}}/img/english.jpg'); background-size: 35px 20px;"> </div> </span> </a>
					</li>
				</ul> 	<!-- language picker end-->
			  
			</div><!--/.nav-collapse -->
		  </div>
		</nav>