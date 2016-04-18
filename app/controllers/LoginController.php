<?php

class LoginController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| LoginController
	|--------------------------------------------------------------------------
	|
	*/

	public function getLogin()
	{
		if (Session::has('userName')) //if already logged in
		{
			Session::forget('userName'); //forget it
		}
		$categories = DB::table('category')->where('lang', Session::get('myLocale') )->get();
		return View::make('login')->with( array('categories' => $categories) );
	}

	public function postLogin()
	{
		//Some paranoia.... (check format)
		$pattern = '/^[A-Za-z0-9\_\?\!]{1,50}$/';
		$rules = array('username' => 'regex:'.$pattern, 'password' => 'regex:'.$pattern);
		$input = Input::all();
		$validator = Validator::make($input, $rules);
		
		if ($validator->fails())  //go back with errors...
		{
			return Redirect::route('login')->withErrors($validator);
		}
		
		//Check if username+password combination exists
		$auth = Auth::attempt( array('username' => Input::get('username'), 'password' => Input::get('password') ), false );
		if (!$auth)
		{
			return Redirect::route('login')->withErrors(array(trans("login.auth_error")));
		}
		
		$userName = Auth::user()->username;
		Session::set('userName', $userName);
		return Redirect::route('private');
		
	}
	
}
