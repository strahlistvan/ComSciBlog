<?php
	require_once('Helper.php');

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	/** Show the index page, the list of the articles in the given language */
	public function showWelcome($pageNum=1)
	{
		//Select posts from database
		$posts = DB::table('post')->where('lang', Session::get('myLocale') )->orderBy('created_at', 'desc')->get();
	
		//validate 
		$pageNum = Helper::clearPageNum($pageNum, $posts);
		$isLastPage = Helper::isLastPage($pageNum, $posts);
		$posts = Helper::sortPostsByDate($posts);
		
		//Find the first paragraphs of the posts (if exists)
		foreach ($posts as $p)
		{
			$p->first_par = Helper::getFirstPar($p->text);
		}
		
		$posts = Helper::getCurrentSlice($posts, $pageNum); //Slice
		$categories = DB::table('category')->where('lang', Session::get('myLocale') )->get();
		$allKeywords = Helper::selectKeywords(Session::get('myLocale'));

		//return view
		return View::make('index')->with(array("posts"=> $posts, "pageNum" => $pageNum, "isLastPage" => $isLastPage, 'allKeywords' => $allKeywords, "categories" => $categories ) );
	}
	
	public function showAboutPage()
	{
		$categories = DB::table('category')->where('lang', Session::get('myLocale') )->get();
		$allKeywords = Helper::selectKeywords(Session::get('myLocale'));
		return View::make('about')->with( array('allKeywords' => $allKeywords, 'categories' => $categories) );
	}
	
	public function showPrivacyPage()
	{
		$categories = DB::table('category')->where('lang', Session::get('myLocale') )->get();
		$allKeywords = Helper::selectKeywords(Session::get('myLocale'));
		return View::make('privacy')->with( array('allKeywords' => $allKeywords, 'categories' => $categories) );
	}
	
	
	/** Show the index page, the list of the articles whitch uses the given keyword */
	public function showByKeyword($keyword, $pageNum=1)
	{
		$keyword = urldecode($keyword);
		$post_id_list = DB::table('keyword')->select('post_id')->where('keyword', $keyword)->get();
		
		//Select posts from database
		foreach ($post_id_list as $p_id)
		{
			$posts[] = DB::table('post')->where('post_id', $p_id->post_id )->first();
		}
		
		//validate 
		$pageNum = Helper::clearPageNum($pageNum, $posts);
		$isLastPage = Helper::isLastPage($pageNum, $posts);
		$posts = Helper::sortPostsByDate($posts);
		
		//Find the first paragraphs of the posts (if exists)
		foreach ($posts as $p)
		{
			$p->first_par = Helper::getFirstPar($p->text);
		}
		
		$posts = Helper::getCurrentSlice($posts, $pageNum) ;
		$categories = DB::table('category')->where('lang', Session::get('myLocale') )->get();
		//Select all possible keywords, in the given language (ONCE!)
		$allKeywords = Helper::selectKeywords(Session::get('myLocale'));
		//return view
		return View::make('index')->with(array("posts"=> $posts, "pageNum" => $pageNum, "isLastPage" => $isLastPage, 'allKeywords' => $allKeywords, 'usedKeyword' => $keyword , "categories" => $categories) );
	}

	/** Show the index page with the list of articles whitch are int the given category */
	public function showByCategory($category, $pageNum=1)
	{
		//Select posts from database (from the given category)
		$cat_id = DB::table('category')->select('category_id')->where('category_name', urldecode($category) )->where('lang', Session::get('myLocale') )->first()->category_id;
		 $category_info = DB::table('category')->where('category_id', $cat_id)->first();
		 $sql = "SELECT * FROM `post_category`INNER JOIN `post` ON `post_category`.post_id =`post`.post_id WHERE `post_category`.category_id=$cat_id ORDER BY post.created_at DESC;";
		 $posts = DB::select($sql);
	
		//validate 
		$pageNum = Helper::clearPageNum($pageNum, $posts);
		$isLastPage = Helper::isLastPage($pageNum, $posts);
		$posts = Helper::sortPostsByDate($posts);
		
		//Find the first paragraphs of the posts (if exists)
		foreach ($posts as $p)
		{
			$p->first_par = Helper::getFirstPar($p->text);
		}
		
		$posts = Helper::getCurrentSlice($posts, $pageNum); //Slice
		$categories = DB::table('category')->where('lang', Session::get('myLocale') )->get();
		$allKeywords = Helper::selectKeywords(Session::get('myLocale'));

		//return view
		return View::make('index')->with(array("posts"=> $posts, "pageNum" => $pageNum, "isLastPage" => $isLastPage, 'allKeywords' => $allKeywords, "categories" => $categories,  'category_info' => $category_info ) );	
	}
	
	/** Shows the full content of the article with given ID */
	public function showArticle($id, $title)
	{
		$article = DB::table('post')->where('post_id', $id)->first();
		
		//Find the first paragraphs of this article (if exists)
		$article->first_par = Helper::getFirstPar($article->text);
		//If the selected article not exist: error!
		if (!$article)
			return View::make('article')->with('error', 'Article not found');
			
		//Select comments of the article:
		$comments = DB::table('comment')->where( 'post_id', $article->post_id )->orderBy('created_at', 'desc')->get();
		
		//Select current keywords: 
		$keywords = DB::table('keyword')->where('post_id', $id)->orderBy('keyword')->get();
		$categories = DB::table('category')->where('lang', Session::get('myLocale') )->get();
		//Select all possible keywords, in the given language (ONCE!)
		$allKeywords = Helper::selectKeywords(Session::get('myLocale'));
		
		//Make the article view
		return View::make('article')->with( array('id' => $id, 'post' => $article, 'comments' => $comments, 'keywords' => $keywords, 'allKeywords' => $allKeywords, 'categories' => $categories ) );
	}
		
	/** Language picker's contoller function */
	public function changeLanguage($lang)
	{
		if (in_array($lang, Config::get('app.languages')) )
		{
			Session::set('myLocale', $lang);
		}
		return Redirect::to('/'); //go back to the main page!
	}
	
	/** Search method for search button (AJAX POST) */
	public function search()
	{
		if (isset($_POST['key']) )
		{
			$key = Helper::text2htmlcodes(strip_tags($_POST['key']));
			$results = DB::table('post')->where('text', 'LIKE', "%$key%")->orwhere('title', 'LIKE', "%$key%")->orderBy('created_at', 'desc')->get();
			foreach ($results as $res)
			{
				$res->first_par = Helper::getFirstPar($res->text);
			}
			return json_encode($results);
		}
		return "error";
	}
}