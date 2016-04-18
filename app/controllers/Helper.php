<?php

	class Helper 
	{
		/** get the current slice (for the blogposts)
		 *   Used in  HomeController@showWelcome, HomeController@showByKeyword
		 *  @param $pageNum - number of the given page
		 *					$posts - array of all posts
		 *  @return  given chunk of the posts array
		*/
		public static function getCurrentSlice($posts, $pageNum)
		{
			$ppp = Config::get("app.posts_per_page");
			$arrays = array_chunk($posts, $ppp, false);
			return (isset($arrays[$pageNum-1]))? $arrays[$pageNum-1]: array();
		}
		
		/** is the given page is the last page?
		 *  Used in  HomeController@showWelcome, HomeController@showByKeyword
		*/
		public static function isLastPage($pageNum, $posts)
		{
			$ppp = Config::get("app.posts_per_page");
			if (  $pageNum*$ppp > count($posts) )
				return true;
			return false;
		}
		
		/** Validate the page number between 1-MAX 
		  * used in HomeController@showWelcome, HomeController@showByKeyword
		  * @param $pageNum - number of the given page
		  *				$posts - array of all posts
		  * @return  The tained page number
		*/
		public static function clearPageNum($pageNum, $posts)
		{
			$ppp = Config::get("app.posts_per_page");
			 if (!is_numeric($pageNum)  || ($pageNum <= 0)  )
					$pageNum = 1;
			return $pageNum;
		}
	
		/** Sorting posts array by created-at property
		 * @param $posts - array of post objects
		 * @return sorted array of pos objects
		*/
		public static function sortPostsByDate($posts)
		{
			usort($posts, function($a, $b) { 
								return ( strtotime($a->created_at) >= strtotime($b->created_at) ) ? -1 : 1;
								});
			return $posts;
		}
		
		
		/** Select all keywords (once), and return with an array of keywords
		* Used in  HomeController@showWelcome, HomeController@showByKeyword, HomeController@showArticle
		* and PrivateController@showWelcome
		*	@param  $lang - language of the keywords
		*/
		public static function selectKeywords($lang='en')
		{
			$allKeywords = DB::table('keyword')->where('lang',$lang)->select('keyword')->orderBy('keyword')->get();
			$allKeywords = array_values( array_unique($allKeywords, SORT_REGULAR) );  	
			return $allKeywords;
		}
		
		/** Make links in texts (stackoverflow...)
		*    Used in CommentController@postComment, CommentController@updateComment
		*				   PrivateController@newBlogPost, PrivateController@updateBlogPost
		*/
		public static function url2link($text)
		{	
			 $pattern =  '%\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))%s';
			 $result = preg_replace($pattern, '<a href="$1" target="_blank">$1</a>', $text);
			 return $result;
		}
		
		/**  Strip all attributes from tags (stackoverflow...)
		  *   Used in CommentController@postComment, CommentController@updateComment 
		  */
		public static function strip_tag_attrs($text)
		{
			$pattern = "/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i";
			$text =  preg_replace($pattern, '<$1$2>', $text);
			return $text;
		}
		
		/** @return the first paragraph of the HTML formatted text
		  *   Used in HomeController@showArticle HomeController@showByKeyword HomeController@search
		*/
		public static function getFirstPar($HTML_text)
		{
			$pos =  mb_strpos($HTML_text, '</p>'); 
			return ($pos)? mb_substr($HTML_text, 0, $pos ) : $HTML_text;
		}
		
		 /** Used in PrivateController@newBlogPost, PrivateController@updateBlogPost
		 * @return tained_text
		*/
		public static function prepareText($text)
		{
			$text = str_replace("<pre>", "<pre><code>", $text);
			$text = str_replace("</pre>", "</code></pre>", $text);
			$text = str_replace("<pre><code><code>", "<pre><code>", $text);
			$text = str_replace("</code></code></pre>", "</code></pre>", $text);
			$text = str_replace("'", "&apos;", $text);
                        $text = str_replace("//", "&#47;&#47;", $text);
            $text = str_replace("<img ", '<img class="img-responsive" ', $text);
			return $text;
		}
		
		/** Convert file size strings to bytes 
         * Used in PrivateController@newBlogPost
		 * @return number
		*/
		public static function toBytes($val) 
		{
			$val = trim($val);
			$last = strtolower($val[strlen($val)-1]);
			switch($last) 
			{   
				case 'g':
					$val *= 1024;
				case 'm':
					$val *= 1024;
				case 'k':
					$val *= 1024;
			}
			return $val;
		}
		
		/** Detect language if we don't picked it */
		public static function detectLanguage()
		{
			if (!Session::has('myLocale'))
			{
				$lang = substr(Request::server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
				//if we find the browser language, that is good!
				if (in_array($lang, Config::get('app.languages')) )
				{
					Session::set('myLocale', $lang);
				}
				else
					Session::set('myLocale', 'en'); //default : english
			}
		}
		
		/** New lines to paragraphs (not necessary -> TinyMCE) */
		public static function nl2p($PostText)
		{
			$postText = nl2br($postText);
			$postText = preg_replace('/<br \/>(\s*<br \/>)+/', '</p><p>', $postText);
			return  '<p>'.$postText.'</p>';
		}
		
		/** Minify HTML output, except pre and textarea tags  (stackoverflow.com: 27878158)*/
		public static function sanitize_output($buffer) 
		{
			// Searching textarea and pre
			preg_match_all('#\<textarea.*\>.*\<\/textarea\>#Uis', $buffer, $foundTxt);
			preg_match_all('#\<pre.*\>.*\<\/pre\>#Uis', $buffer, $foundPre);

			// replacing both with <textarea>$index</textarea> / <pre>$index</pre>
			$buffer = str_replace($foundTxt[0], array_map(function($el){ return '<textarea>'.$el.'</textarea>'; }, array_keys($foundTxt[0])), $buffer);
			$buffer = str_replace($foundPre[0], array_map(function($el){ return '<pre>'.$el.'</pre>'; }, array_keys($foundPre[0])), $buffer);

			$search = array(
				'/\>[^\S ]+/s',  // strip whitespaces after tags, except space
				'/[^\S ]+\</s',  // strip whitespaces before tags, except space
				'/(\s)+/s'       // shorten multiple whitespace sequences
			);

			$replace = array('>', '<', '\\1');
			$buffer = preg_replace($search, $replace, $buffer);

			// Replacing back with content
			$buffer = str_replace(array_map(function($el){ return '<textarea>'.$el.'</textarea>'; }, array_keys($foundTxt[0])), $foundTxt[0], $buffer);
			$buffer = str_replace(array_map(function($el){ return '<pre>'.$el.'</pre>'; }, array_keys($foundPre[0])), $foundPre[0], $buffer);

			return $buffer;
		}	
		
		public static function text2htmlcodes($text)
		{	
			$html_codes = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&ouml;", "&ocirc;", "&uuml;", "&ucirc;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;", "&Ouml;", "&Ocirc;", "&Uuml;", "&Ucirc;");
			$characters = array("á", "é", "í", "ó", "ú", "ö", "ő", "ü", "ű", "Á", "É", "Í", "Ó", "Ú", "Ö", "Ő", "Ü", "Ű" );
		
			return str_replace($characters, $html_codes, $text);
		}

		
	}
?>