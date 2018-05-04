<?php

use App\Traits\Uuid;
use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	use Uuid;
	public function run() {
		$user           = new User();
		$user->name     = 'Administrator';
		$user->email    = 'administrator@gmail.com';
		$user->password = bcrypt('123456');
		$user->foto     = '';
		$user->save();
	}
}
