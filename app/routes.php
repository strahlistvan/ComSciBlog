<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/** Home page */
Route::get('/', 'HomeController@showWelcome');
Route::get("/about", 'HomeController@showAboutPage');
Route::get("/index", array("as" => "index", "uses" => "HomeController@showWelcome") );
Route::get('/page/{pageNum}', array('uses' => 'HomeController@showWelcome') );
Route::get('/article/{id}/{title}',  array('as' =>'/article/{id}', 'uses' => 'HomeController@showArticle' ) );
Route::get('/keyword/{keyword}', array('uses' => 'HomeController@showByKeyword') );
Route::get('/keyword/{keyword}/{pageNum}', array('uses' => 'HomeController@showByKeyword') );
Route::get("/category/{category}", array('uses' => 'HomeController@showByCategory' ) );
Route::post('searching', 'HomeController@search');

/** Login page */
Route::get( '/login', array('as' => 'login', 'uses' => 'LoginController@getLogin') );
Route::post('login', array('uses' => 'LoginController@postLogin', 'before' => 'csrf') );

/** Logout and go back */
Route::get('logout', 'LogoutController@logout');
Route::post('logout', 'LogoutContoller@logout');

Route::post("postComment", array("uses" => "CommentController@postComment", "before" => "csrf") );
Route::post("updateComment", array("uses" => "CommentController@updateComment", "before" => "csrf") );
Route::post("deleteComment", array("uses" => "CommentController@deleteComment", "before" => "csrf") );

/** Admin interface: */
Route::get('/private',  array ('as' => 'private', 'uses' => 'PrivateController@showWelcome') );
Route::post('new_post', 'PrivateController@newBlogPost');
Route::post('update_post', 'PrivateController@updateBlogPost');
Route::post('delete_post', array( 'uses' => 'PrivateController@deleteBlogPost', 'before' => 'csrf') );
Route::post('addKeyword', 'PrivateController@addKeyword');
Route::post('delKeyword', 'PrivateController@delKeyword');
Route::post('getKeywords', 'PrivateController@getKeywords');
Route::post('getPostById', 'PrivateController@getPostById');
Route::post('addToCategory', 'PrivateController@addToCategory');

Route::post('uploadImage', 'PrivateController@uploadImage');


/** Language picker */
Route::get( '/{lang}', array('as' => '{lang}', 'uses' => 'HomeController@changeLanguage') );
