<!DOCTYPE html>

<html lang="{{ Session::get('myLocale') }}" >
	<head> 
		<meta charset='utf-8' />
		<link href='{{url()}}/css/bootstrap.min.css' rel='stylesheet' type='text/css' />
		<link rel="stylesheet" href="{{url()}}/js/CLEditor/jquery.cleditor.css" >
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		@yield('metadata')
		<meta name="robots" content="noindex, nofollow">
		<link rel="icon" href="favicon.png" type="image/png"/>
		<link rel="shortcut icon" type="image/png" href="favicon.png"/>
	</head>
	
	<body>
		
		@include('navbar')
		
		<div class='container'>
			<div class='jumbotron'>
			@yield('content')
			</div>

		</div>
		
                
		<script src="{{url()}}/js/bootstrap.min.js" type='text/JavaScript'> </script>
		<!-- TinyMCE text editor -->
		<script type="text/javascript" src="{{ url() }}/js/tinymce/tinymce.min.js"></script>
		
		<script type="text/javascript">
			tinymce.init({
				language: "{{ Session::get('myLocale') }}",
				selector: "textarea#post_text, textarea#update_text",
				dialog_type : "window",
				menubar: "edit insert table tools format",
				plugins: [
					"advlist lists link image charmap preview anchor",
					"searchreplace code",
					"insertdatetime media table contextmenu paste wordcount"
				],
                                convert_urls:false,
                                relative_urls:false,
                                remove_script_host : false,
				toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent code| ",
		//		valid_elements : "a[href|target=_blank],strong/b,div[align],p,br,pre",
			});
		</script>
		
	</body>
	
</html>