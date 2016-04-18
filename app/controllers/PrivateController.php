<?php
	
require_once('Helper.php');

class PrivateController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Admin Controller
	|--------------------------------------------------------------------------
	*/

	/** Check authentication */
	public function showWelcome()
	{
		if (!Session::has('userName')) //Security 'filter'
		{
			return Redirect::route('index');
		}
		$conditions = array('username' => Session::get('userName'), 'lang' => Session::get('myLocale') );
		$posts = DB::table('post')->where($conditions)->orderBy('created_at', 'desc')->get();
		$keywords = Helper::selectKeywords(Session::get('myLocale'));
		$images = DB::table('image')->get();
		$categories = DB::table('category')->where('lang', Session::get('myLocale') )->get();
		
		return View::make('admin')->with(  array('posts' => $posts, 'keywords' => $keywords, 'images' => $images, 'categories' => $categories) );
	}
	
	/** Update the sended blogpost  */
	public function updateBlogPost()
	{
		if (!Session::has('userName')) //Security 'filter'
		{
			return Redirect::route('index');
		}
		//Clear input (some paranoia...)
		$updateTitle = htmlspecialchars(Input::get('update_title'));
		$updateText = Helper::prepareText(Input::get('update_text'));
		$updateID = strip_tags(Input::get('updateID'));
		
		//More paranoia.... (check format)
		$pattern = '/^[^<>\']+$/';
		$rules = array('update_title' => 'required|max:200|regex:'.$pattern, 'update_text' => 'required', 'updateID' => 'numeric');
		$input = array( 'update_title' => $updateTitle, 'update_text' => $updateText, 'updateID' => $updateID );
		$validator = Validator::make($input , $rules);
		
		if ($validator->fails())  //go back with errors...
		{
			return Redirect::route('private')->withErrors($validator);
		}
		
		//Update the given post
		$now = date('Y-m-d h:i:s', time());
		DB::table('post')->where('post_id', $updateID)->update( array('title' => $updateTitle, 'text' => $updateText, 'updated_at' => $now ) );
		
		//update keywords to database:
		if (Session::has('keywords'))
		{
			DB::transaction(function($now) use ($now){ 
				$sql = "SELECT post_id FROM post WHERE username=? AND updated_at=?;";
				$data = array(Session::get('userName'), $now);
				$current_id = DB::select($sql, $data)[0]->post_id;
				//clear previous, and then insert new keywords
				DB::table('keyword')->where('post_id', $current_id)->delete();
				foreach (Session::get('keywords') as $kw )
				{
					DB::table('keyword')->insert( array('post_id' => $current_id, 'keyword' => $kw, 'lang' => Session::get('myLocale') ) );
				}
				Session::forget('keywords');
			});
		}
		
		return Redirect::back()->with('success', 'Successful');
	}
	
	/** Insert new blogpost to the database */
	public function newBlogPost()
	{
		if (!Session::has('userName')) //Security 'filter'
		{
			return Redirect::route('index');
		}

		//Clear input (some paranoia...)
		$postTitle = htmlspecialchars(Input::get('post_title'));
		$postText = Helper::prepareText(Input::get('post_text'));

		//More paranoia.... (check format)
		$pattern = '/^[^<>\']+$/';
		$rules = array('post_title' => 'required|max:200|regex:'.$pattern, 'post_text' => 'required');
		$input = array( 'post_title' => $postTitle, 'post_text' => $postText );
		$validator = Validator::make($input , $rules);
		
		if ($validator->fails())  //go back with errors...
		{
			return Redirect::route('private')->withErrors($validator);
		}
		
		//Insert into database
		$now = date('Y-m-d h:i:s ', time());
		$sql = "INSERT INTO post (username, title, text, lang, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?);";
		$data = array (Session::get('userName'), $postTitle, $postText, Session::get('myLocale'), $now, $now);
		DB::insert($sql, $data);
		
		//Insert keywords to database:
		if (Session::has('keywords'))
		{
			$sql = "SELECT post_id FROM post WHERE username=? AND created_at=?;";
			$data = array(Session::get('userName'), $now);
			$current_id = DB::select($sql, $data)[0]->post_id;
			foreach (Session::get('keywords') as $kw )
			{
				DB::table('keyword')->insert( array('post_id' => $current_id, 'keyword' => $kw, 'lang' => Session::get('myLocale') ) );
			}
			Session::forget('keywords');
		}
		return Redirect::route('private')->with('success', 'Successful!');
	}
	
	/**  Image uploader function*/
	public function uploadImage()
	{

		if (Input::hasFile('images'))
		{
			$imgCount = count($_FILES['images']['name']);
			 for ($i=0; $i<$imgCount; ++$i)
			 {
				$maxSize  = Helper::toBytes(ini_get('upload_max_filesize'));
				if ($_FILES['images']['size'][$i] > $maxSize )
					return Redirect::route('/private')->withErrors(array('error' => 'Uploaded file is bigger than'.$maxSize) );
			 
				 $tmpFilePath = $_FILES['images']['tmp_name'][$i];
				 if ($tmpFilePath != "")
				  {
						//Setup our new file path
						$newFilePath = public_path()."/img/" . $_FILES['images']['name'][$i];
						
						//If the current file already exists in server
						while ( file_exists($newFilePath) )
						{
							$ext = mb_substr($newFilePath, -4);
							$newFilePath = mb_substr($newFilePath, 0, -4);
							
							if ( is_numeric( mb_substr($newFilePath, -1) )  )
							{
								$num = (int)mb_substr($newFilePath, -1) +1;
								$newFilePath = mb_substr($newFilePath, 0, -1) . $num.$ext;
							}
							else 
								$newFilePath.="01".$ext;
						}
						
						//Upload the file from the temp dir to the final dir
						if(move_uploaded_file($tmpFilePath, $newFilePath)) 
						{
							$folder = "img";
							$startPos = mb_strrpos($newFilePath, "/");
							$endPos = mb_strlen($newFilePath);
							$fileName = mb_substr($newFilePath, $startPos, $endPos);
							DB::table('image')->insert(array('image_path' => $folder.$fileName) );
						}
						else //error 
							  return Redirect::route('/private')->withErrors(array('error' => 'Error while uploading files.') );
				  }
			 }
		}
		return  Redirect::route('private')->with('success', 'Successful');
	}
		
	/** Delete a blog post */
	public function deleteBlogPost()
	{
		 if (!Session::has('userName') || !is_numeric( Input::get('delPostID') ) )
			return Redirect::back();
		
		$id = strip_tags(Input::get('delPostID') );
		DB::table('post')->where('post_id', $id)->delete();
		DB::table('keyword')->where('post_id', $id)->delete();
		
		return Redirect::back()->with('delSuccess', 'successfully deleted');
	}

		
	/** get the selected Post JSON object by the given ID (used by AJAX POST call) */
	public function getPostById()
	{
			if (isset($_POST['post_id']) )
			{
				$post_id = trim( addslashes($_POST['post_id']) );
				$post = DB::table('post')->where('post_id', $post_id)->first();
				return  json_encode($post);
			}
				
			return "FAILED";
	}
	
	/** Store selected keywords to a session variable (used by AJAX POST call) */
	public function addKeyword()
	{
		if (isset($_POST['keywords']) )
		{
			 //$keywords = trim( addslashes($_POST['keywords']) ); 
			Session::put('keywords', $_POST['keywords']); //nem bizt.
			return "ok"; 
		}

		return "not ok";
	}
	
	/**  Remove a keyword from the session array (used by AJAX POST call) */
	public function delKeyword()  //BAD BAD FUNCTION
	{
		/* if (isset($_POST['keyword']) )
		 {
			$arr = Session::get('keywords');
			$key = array_search( $_POST['keyword'], $arr);
                        echo $arr;
			//if ( $key !== false )
			//{
				unset($arr[$key]);
				//$arr = array_values($arr);
				Session::put('keywords', $arr);
				//if (empty($arr))
				//    Session::forget('keywords');
			//}
                
			return "ok";
		 }
             
		return "not ok";
               */
	}
	
	/** Select all the keywords from database (used by AJAX  POST call) */
	public function getKeywords()
	{
		if (!isset($_POST['post_id']) )
			return false;
		
		$keywords = DB::table('keyword')->select('keyword')->where('post_id', $_POST['post_id'])->get();
		return ( json_encode($keywords) );		
	}
	
	public function addToCategory()
	{
		if ( !isset($_POST['category_id'], $_POST['post_id']) || !is_numeric($_POST['category_id']) || !is_numeric($_POST['post_id']) )
			return false;
		$category_id = trim(addslashes($_POST['category_id']));
		$post_id = trim(addslashes($_POST['post_id']));
		
		//if not exist the current relation between category and post, insert it
		$result = DB::table('post_category')->where('post_id', $post_id)->where('category_id', $category_id)->first();
		if ( empty($result) )
			DB::table('post_category')->insert( array('category_id' => $category_id, 'post_id' => $post_id)  );
		
		$post_title = DB::table('post')->where('post_id', $post_id)->first()->title;
		$category_name = DB::table('category')->where('category_id', $category_id)->first()->category_name;
		return json_encode(array('post_title' => $post_title, 'category_name' => $category_name));
	}
	
}
	