<?php

require_once("Helper.php");

class CommentController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	|  Controllers of the Comment functions (store and modify)
	|--------------------------------------------------------------------------
	|
	*/

	/** Store new comment */
	public function postComment()
	{
		$name = strip_tags(Input::get("name"));
		$text = strip_tags(Input::get('text'), '<b> <u> <i> <pre> ');
		$postID = strip_tags(Input::get('postID'));
		
		$text = Helper::strip_tag_attrs($text);  //strip all attributes
		$text = Helper::url2link($text);  //make links
		//pre tags to contain code:
	    $text = str_replace("<pre>", "<pre><code>", $text);
		$text = str_replace("</pre>", "</code></pre>", $text);
		 
		 //Validation: 
		 if (!Input::has("g-recaptcha-response") || Input::get("g-recaptcha-response")=="" || Input::get("g-recaptcha-response")==" " )
			return Redirect::back()->withErrors( array (trans('public.captcha') ) ); 
		 
		$rules = array('name' => 'required|max:100', 'text' => 'required', 'postID' => 'numeric');
		$input = array('name' => $name, 'text' => $text, 'postID' =>$postID);
		$validator = Validator::make($input, $rules);
		if ($validator->fails())  //go back with errors...
		{
			return Redirect::back()->withErrors($validator);
		}
	
		$cookieName = 'comsci-comment-'.sha1(time() . Request::getClientIp() );
		$now = date('Y-m-d h:i:s ', time());
		DB::table('comment')->insert( array('post_id' => $postID, 'writer' => $name, 'text' => $text,  'cookie_name' => $cookieName,  'created_at' => $now, 'updated_at' => $now ) );
		
		Cookie::queue($cookieName, sha1($now), 2628000);
		return Redirect::back()->withCookie( Cookie::forever($cookieName, sha1($now) ) );
	}
	
	public function updateComment()
	{
		$name = strip_tags(Input::get("updateName"));
		$text = strip_tags(Input::get('updateText'), '<b> <u> <i> <pre> ');
		$postID = strip_tags(Input::get('updatePostID'));
		$commentID = strip_tags(Input::get('updateID'));
		
		$text = Helper::strip_tag_attrs($text);  //strip all attributes
		$text = Helper::url2link($text);
		//pre tags to contain code:
	    $text = str_replace("<pre>", "<pre><code>", $text);
		$text = str_replace("</pre>", "</code></pre>", $text);
		 
		 //Validation: 
		 if (!Input::has("g-recaptcha-response") || Input::get("g-recaptcha-response")=="" || Input::get("g-recaptcha-response")==" " )
			return Redirect::back()->withErrors( array (trans('public.captcha') ) );
		 
		$rules = array('name' => 'required|max:100', 'text' => 'required', 'postID' => 'numeric', 'commentID' => 'numeric');
		$input = array('name' => $name, 'text' => $text, 'postID' =>$postID, 'commentID' => $commentID);
		$validator = Validator::make($input, $rules);
		if ($validator->fails())  //go back with errors...
		{
			return Redirect::back()->withErrors($validator);
		}
	
		$now = date('Y-m-d h:i:s ', time());
		DB::table('comment')->where('comment_id', $commentID)->update(array('writer' => $name, 'text' => $text, 'updated_at' => $now ) );
		
		return Redirect::back();
	}
	
	public function deleteComment()
	{
		var_dump(Input::all());
		$id = strip_tags(Input::get("delCommentID"));
		
		if (!is_numeric($id))
			return Redirect::back();
		
		DB::table('comment')->where('comment_id', $id)->delete();
		return Redirect::back();
		
	}
}