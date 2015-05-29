<?php namespace App\Http\Controllers;

use Auth;
use Exception;

use App\Http\Requests;
use App\Services\ProfilesService;
use App\Http\Controllers\Controller;
use App\Services\Responder as Responder;

use Illuminate\Http\Request;

class ProfileController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		try {
			// get logged in users profile info
			$profile = ProfilesService::getProfileByUserId(Auth::id());
			return Responder::success($profile);
		} catch (Exception $e) {
			return Responder::failureMessage('Error: ' . $e->getMessage());
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		try {
			// update the logged in users profile info
			ProfilesService::updateProfile(Auth::id());
			return Responder::successMessage('Success: Your profile has been updated');
		} catch (Exception $e) {
			return Responder::failureMessage('Error: ' . $e->getMessage());
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

}
