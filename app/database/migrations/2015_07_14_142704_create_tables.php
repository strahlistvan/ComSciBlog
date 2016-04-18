<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration {

/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	 public function up()
	 {
		/** Create User table */
		Schema::create('user', function($table)
		{
			$table->increments('user_id');
			$table->string('username')->unique();
			$table->string('password');
			$table->string('email')->unique();
			$table->timestamps();
		});
		
		/** Create Post table */
		Schema::create('post', function($table)
		{
			$table->increments('post_id');
			$table->string('username');
			$table->string('title');
			$table->string('lang', 10);
			$table->text('text');
			$table->timestamps();
		});
		
		
		/** Create Comment table */
		Schema::create('comment', function($table)
		{
			$table->increments('comment_id');
			$table->integer('post_id');
			$table->string('writer');
			$table->text('text');
			$table->string("cookie_name");
			$table->timestamps();
		});
		  
		 /** Create Keywords table */
		 Schema::create('keyword', function($table)
		 {
				$table->increments('keyword_id');
				$table->integer('post_id');
				$table->string('keyword')->unique();
				$table->string('lang', 10);
		 });
	
	}
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user');
		Schema::drop('post');
		Schema::drop('comment');
		Schema::drop('keyword');
	}

}
