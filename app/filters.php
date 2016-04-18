<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

include('controllers/Helper.php');

//Change 'public' folder to 'public_html'
App::bind('path.public', function() {
    return base_path().'/public_html';
});


App::before(function($request)
{
	//try to detect browser language
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
} );


//Minify HTML output: (laravelsnippets.com)
App::after(function($request, $response)
{
		if($response instanceof Illuminate\Http\Response)
		 {
			$output = $response->getOriginalContent();
			 // Clean comments
			$output = preg_replace('/<!--([^\[|(<!)].*)/', '', $output);
			$output = preg_replace('/(?<!\S)\/\/\s*[^\r\n]*/', '', $output);
			 // Clean Whitespace

			$output = Helper::sanitize_output($output);
			$response->setContent($output);
		 }
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
