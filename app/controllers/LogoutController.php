<?php

class LogoutController extends BaseController 
{
	 public function logout()
	 {
		Session::forget('userName');
		return Redirect::back();
	 }
}