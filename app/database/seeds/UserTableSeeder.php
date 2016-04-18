<?php

class UserTableSeeder extends Seeder
{
	
		/**  Seeding the tables! */
		public function run()
		{
			DB::table('user')->delete(); //Clear user table
			$userArray = array ('username' => 'admin', 'password' =>  Hash::make('v3ryb1gs3cr3t'), 'email' => 'strahlistvan0@gmail.com' );
			User::create($userArray);
		}
}
