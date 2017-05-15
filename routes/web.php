<?php

use App\Events\UserHasRegistered;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
	Route::get('/', function () {
	    return view('welcome');
	});

	Route::get('broadcast', function() {
		//* Automatically refreshes evrytime a new 'user' or 'task' is created without having to refresh the page.
		$name = Request::input('name');
		event(new UserHasRegistered($name));

		return 'Done';
	});

	Route::resource('posts', 'PostsController');