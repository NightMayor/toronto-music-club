<?php namespace App\Http\Controllers;

use Auth;
use Exception;

use App\Http\Requests;
use App\Services\ThreadsService;
use App\Http\Controllers\Controller;
use App\Services\Responder as Responder;

use Illuminate\Http\Request;

class ThreadsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		try {
			// get all of the logged in users Threads
			$threads = ThreadsService::getThreadsByUserId(Auth::id());
			return Responder::success($threads);
		} catch (Exception $e) {
			return Responder::failureMessage('Error: ' . $e->getMessage());
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		try {
			// create a new Thread by the logged in user
			ThreadsService::createThread(Auth::id());
			return Responder::successMessage('Success: Message Sent');
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
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
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
		try {
			// create a new Message within an existing Thread by the logged in user
			ThreadsService::replyMessage(Auth::id(), $id);
			return Responder::successMessage('Success: Message Sent');
		} catch (Exception $e) {
			return Responder::failureMessage('Error: ' . $e->getMessage());
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		try {
			// delete users thread by id
			ThreadsService::deleteUsersThreadById($id);
			return Responder::successMessage('Success: Conversation has been moved to trash');
		} catch (Exception $e) {
			return Responder::failureMessage('Error: ' . $e->getMessage());
		}
	}

}
