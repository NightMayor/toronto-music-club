<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::group([
	'middleware' => 'auth',
	], function() {
		resource('instruments', 'InstrumentsController');
		resource('profile', 'ProfileController');
		resource('genders', 'GendersController');
		resource('subscriptions', 'SubscriptionsController');
		resource('available-posts', 'AvailablePostsController');
		resource('seeking-posts', 'SeekingPostsController');
	}
);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
