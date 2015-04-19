<?php namespace App\Http\Controllers;

use Auth;
use App\User;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		// $stuff = Auth::id();
		// View::share('stuff', $stuff);

		$user_id = Auth::id();
		$user_info = User::find($user_id);
		// dd($user_info);
		view()->share('stuff', $user_info);

		return view('home');
	}

}
