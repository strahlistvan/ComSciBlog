@extends('default_layout')

@section('metadata')
	<title> {{ trans('admin-ui.logged-in-as').Session::get('userName') }} </title>
	<link href="{{url() }}/css/default.css" rel="stylesheet" type="text/css" />
	<script src="{{ url() }}/js/admin.js" type="text/javascript" > </script> 
@stop

@section('content')
	<h1> {{ trans('admin-ui.admin-ui') }} </h1>
	<p>{{ trans('admin-ui.dear').Session::get('userName').trans('admin-ui.lang-note') }} </p>
	 
	 <button class='btn btn-primary' data-toggle='modal' data-target='#newPostModal' title="{{ trans('admin-ui.create-new-post') }}"> {{ trans('admin-ui.new-post') }} </button> 
	  
	   <button class='btn btn-primary' data-toggle='modal' data-target='#galleryModal'> <span class="glyphicon glyphicon-picture"> </span> {{ trans('admin-ui.gallery') }} </button> 
	  
	  <hr />
	  <p> {{ trans('admin-ui.edit-note') }} </p>
	  
	  <select id='postSelect' class='form-control'>
		  <option selected> ---------------- </option>
		  @foreach ($posts as $p)
				<option value='{{ $p->post_id }}' > {{ $p->title }} </option>
		  @endforeach
	  </select>
	  <button type='button' class='btn btn-default' id='updatePostButton'> <span class='glyphicon glyphicon-pencil'> </span>{{ trans('admin-ui.edit') }} </button>
	  <button type='button' class='btn btn-default' id='deletePostButton'> <span class='glyphicon glyphicon-trash'> </span> {{ trans('admin-ui.delete') }} </button>
	  
	  <p>  <br />  {{ trans('admin-ui.cat-manage') }} </p>
	  <select id='categorySelect' class='form-control' >
		  <option selected> ---------------- </option>
		  @foreach ($categories as $cat)
				<option value={{ $cat->category_id }} > {{ $cat->category_name }} </option>
		  @endforeach
	  </select> 
	  <button type='button' class='btn btn-default' id='add2CatButton' > <span class='glyphicon glyphicon-tags'> </span>  &nbsp; {{ trans('admin-ui.add-to-cat') }} </button>
	  
	  <div class='alert alert-danger fade in' id='error-post-cat' >
			<span class='close' > &times; </span> <!-- close button -->
			<b> {{  trans('adminui.error') }}: </b>  {{ trans('admin-ui.error-post-cat') }}  <br />
	  </div>
	  <div class='alert alert-success fade in' id='add-post-cat-alert' >
			<span class='close' > &times; </span> <!-- close button -->
			<b>Info:</b> &quot;<span id="add-post-title"> </span>&quot; {{ trans('admin-ui.add-to-cat-success') }}  &quot;<span id="add-category-name"> </span>&quot; <br />
		</div>
	  
	  <table class='table table-striped' id='mytable'>
		<thead>
			<tr>
				<th> {{ trans('admin-ui.post-title') }} </th>
				<th> {{ trans('admin-ui.published') }} </th>
				<th> {{ trans('admin-ui.lastmod')}} </th>
				<th>{{ trans('admin-ui.edit') }}</th>
				<th> {{  trans('admin-ui.delete') }} </th>
			</tr>
		</thead>
		
		<tbody>
			@foreach ($posts as $p)
				<tr>
					<td data-toggle='modal' data-target='#updateModal' title="{{ trans('admin-ui.edit') }}: '{{$p->title}}' " onclick='update({{ $p->post_id }})'> {{ $p->title }} </td>
					<td data-toggle='modal' data-target='#updateModal' title="{{ trans('admin-ui.edit') }}: '{{$p->title}}' " onclick='update({{$p->post_id }})'>{{ $p->created_at }} </td>
					<td data-toggle='modal' data-target='#updateModal' title="{{ trans('admin-ui.edit') }}: '{{$p->title}}' " onclick='update({{ $p->post_id }})'> {{ $p->updated_at }} </td>
					<td  data-toggle='modal' data-target='#updateModal' title="{{ trans('admin-ui.edit') }}: '{{$p->title}}' " onclick='update({{ $p->post_id }})' > <span class='glyphicon glyphicon-pencil' > </span> </td>
					<td data-toggle='modal' data-target='#deleteModal'  title="{{ trans('admin-ui.delete') }}: '{{$p->title}}' " onclick='delPost({{ $p->post_id }})' > <span class='glyphicon glyphicon-trash'> </span> </td>
				</tr>
			@endforeach
		</tbody>
	  </table>

	  <!-- New post Modal -->
	<div id="newPostModal" class="modal" role="dialog">
	    <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"> {{ trans('admin-ui.write-new-post') }} </h4>
				</div>
			  
			  <div class="modal-body">
					<p> {{ trans('admin-ui.LaTeX') }} </p>
					 
					 {{ Form::open( array('action' => 'PrivateController@newBlogPost', 'autocomplete' => 'off' , 'name' => 'modalForm' ) ) }}
						<div class="form-group">
							<label for="post_title"> {{ trans('admin-ui.new-post-title') }}</label>
							<input name="post_title" id="post_title"  class="form-control" placeholder="{{trans('admin-ui.write-title') }}" required>
						</div>
						<div class="form-group">
							<label for="post_text">{{ trans('admin-ui.write-post')}}</label>
							<textarea name="post_text" id='post_text' class='form-control'  style='height: 25em; resize: none;' required> </textarea>
						</div>
						
						<!--  Select keywords for the article -->
						<label for ='selectKeyword'> {{ trans('admin-ui.select-keyword') }}</label>
						<select class='form-control' name='selectKeyword' id='selectKeyword' >
							<option value="" selected > -- {{ trans('admin-ui.choose') }} -- </option>
							@foreach ($keywords as $k)
							<option value='{{ $k->keyword }}'> {{ $k->keyword }} </option>
							@endforeach
						</select>
						<div class='withMargin'> {{ trans('admin-ui.keyword-commas') }} </div>
						<div class='row' >
							<div class='col-md-6'>
								<div class='input-group'>
									<label for='newKeyword' class='input-group-addon' > {{ trans('admin-ui.add-new-keyword')  }} </label> 
									<input name='newKeyword' id ='newKeyword'  class='form-control' value=''/> 
								</div>
							</div>
							<div class='col-md-6'>
								<button type='button' class='btn btn-info' id='addNewKeyword'>  {{ trans('admin-ui.add-new-keyword')  }}  </button>
							</div>
						</div>
						<div id='keyword-list' class='row'> </div> <!-- end keywords -->
						
						<div style='text-align: center' > <button type="submit" name='ok_post' class="btn btn-primary">{{ trans('admin-ui.store') }} </button> </div>
					{{ Form::close() }}

			  </div> <!-- end modal-body-->
			</div> <!-- end content -->

		</div> 
	</div> <!-- end modal -->
	
	<!-- Update post Modal -->
	<div id="updateModal" class="modal" role="dialog">
	    <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"> {{ trans('admin-ui.update-post') }} </h4>
				</div>
			  
			  <div class="modal-body">
					<p> {{trans('admin-ui.LaTeX') }}</p>
					 
					 {{ Form::open( array('name' => 'updatePostForm' , 'action' => 'PrivateController@updateBlogPost' ) ) }}
						<div class="form-group">
							<label for="update_title"> {{ trans('admin-ui.update-post-title') }}</label>
							<input name="update_title" id="update_title"  class="form-control" placeholder="{{ trans('admin-ui.write-title') }}" value='' required />
						</div>
						<div class="form-group">
							<label for="update_text">{{ trans('admin-ui.write-title') }}</label>
							<textarea name="update_text" id='update_text' class='form-control'  style='height: 25em; resize: none;' required> </textarea>
						</div>
						
						<!--  Select keywords for the article -->
						<label for ='selectKeyword2'> {{ trans('admin-ui.select-keyword') }}</label>
						<p> {{ trans('admin-ui.keyword-commas') }} </p>
						<select class='form-control' name='selectKeyword2' id='selectKeyword2' >
							<option value="" selected > -- {{ trans('admin-ui.choose') }} -- </option>
							@foreach ($keywords as $k)
								<option value='{{ $k->keyword }}'> {{ $k->keyword }} </option>
							@endforeach
						</select>
						<div class='row' style='margin-top: 10px;'>
							<div class='col-md-6'>
								<div class='input-group'>
									<label for='newKeyword2' class='input-group-addon' > {{ trans('admin-ui.add-new-keyword') }}</label> 
									<input name='newKeyword2' id ='newKeyword2'  class='form-control' value=''/> 
								</div>
							</div>
							<div class='col-md-6'>
								<button type='button' class='btn btn-info' id='addNewKeyword2'>   {{ trans('admin-ui.add-new-keyword') }} </button>
							</div>
						</div>
						<div id='keyword-list2' class='row'> </div> <!-- end keywords -->
						
						
						<div style='text-align: center' > <button type="submit" name='ok_update' class="btn btn-primary"> {{ trans('admin-ui.update-post') }}</button> </div>
					{{ Form::close() }}

			  </div> <!-- end modal-body-->
			</div> <!-- end content -->

		</div> 
	</div> <!-- end modal -->
	
	
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
				<h3 id='delPostTitle'>  </h3>
				<div id='delPostFirstPar'> </div>		
			</div>
			<div class="modal-footer">
				{{ Form::open( array('action' => 'PrivateController@deleteBlogPost') ) }}
					<input type='hidden' name='delPostID' id='delPostID' value='' />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger" name='delOK' >Save changes</button>
				{{ Form::close() }}
			</div>
		  </div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<!-- Gallery Modal  -->
	<div id="galleryModal" class="modal" role="dialog">
	    <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"> {{ trans('admin-ui.gallery') }} </h4>
				</div>
			  
			  <div class="modal-body">
					<p> {{ trans('admin-ui.img-upload') }} </p>
					
					{{ Form::open( array('action' => 'PrivateController@uploadImage', 'method' => 'post', 'enctype' => 'multipart/form-data' ) )  }}
						<div class='form-group'>

							<label>  {{ trans('admin-ui.img-upload') }} </label> <br />

							<div class="input-group">
								<span class="input-group-btn">
									<span class="btn btn-default btn-file">
										{{ trans('admin-ui.new-image') }}&hellip; <input type="file" name="images[]" id="images" multiple  required />
									</span>
								</span>
								<input type="text" class="form-control" readonly>
								
							</div>
							<button type='submit' class='btn btn-primary' name='uploadImageOK' id='uploadImageOK' > {{ trans('admin-ui.img-upload') }}</button>
							
							{{ Form::close() }}
							<!-- ERROR WINDOWS -->
							<div class='alert alert-danger' id='errorFormatPanel' >
								<span class='close' > &times; </span> <!-- close button -->
								<b>{{ trans('login.error') }}</b>
								{{ trans('admin-ui.error-format') }} <span class="errorFileName"> </span> <br />
								 <i>{{ trans('admin-ui.format-note') }}</i>								 
							</div>
							
							<div class='alert alert-danger' id='errorSizePanel' >
								<span class='close' > &times; </span> <!-- close button -->
								<b>{{ trans('login.error') }}</b>
								{{ trans('admin-ui.error-size') }} <span class="errorFileName"> </span> <br />
								<i>{{ trans('admin-ui.size-note') }}</i>
							</div>
								
							<div class='alert alert-danger' id='errorNamePanel' >
								<span class='close' > &times; </span> <!-- close button -->
								<b>{{ trans('login.error') }}</b>
								{{ trans('admin-ui.error-name') }} <span class="errorFileName"> </span> <br />
								<i>{{ trans('admin-ui.name-note') }}</i>
							</div>
							
						</div>
					{{ Form::close() }}
					
					<p> {{ trans('admin-ui.uploaded') }} </p>
					
					<div data-spy="scroll" height="200"> <!-- image gallery -->
						@for ($i=0; $i<count($images);  $i+=3)
						<div class="row">
							@for ($j=0; $j<3 && ($i+$j) < count($images); ++$j)
								<div class='col-md-4'>
									<img src="{{ $images[$i+$j]->image_path }}" alt="picture"   class="img-responsive" />
									{{ $images[$i+$j]->image_path }}  <span class="glyphicon glyphicon-trash" title="{{ trans('admin-ui.delete') }}"> </span> 
								</div> 
							@endfor
						</div> <br />
						@endfor
					</div>
					
			  </div> <!-- end modal-body-->
			</div> <!-- end content -->

		</div> 
	</div> <!-- end modal -->
	
	
	
	@foreach ($errors->all() as $error)
		 <!-- Error window -->
	     <div class='alert alert-danger fade in'>
			<span class='close' data-dismiss='alert'> &times; </span> <!-- close button -->
			<b>{{ trans('admin-ui.error') }}</b> {{ $error }} <br />
			{{ trans('admin-ui.note') }}
		</div>
	@endforeach
	
	@if (Session::has('success') )
		  <div class='alert alert-success fade in' >
			<span class='close' data-dismiss='alert'> &times; </span> <!-- close button -->
			<b>Info:</b> {{ trans('admin-ui.success') }} <br />
		</div>
	@endif
	
	@if (Session::has('delSuccess'))
		<div class='alert alert-success fade in' >
			<span class='close' data-dismiss='alert'> &times; </span> <!-- close button -->
			<b>Info:</b> {{ trans('admin-ui.delSuccess') }} <br />
		</div>
	@endif
	  
@stop