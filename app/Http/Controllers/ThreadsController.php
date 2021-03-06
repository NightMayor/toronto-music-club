<?php namespace App\Http\Controllers;

use Auth;
use Input;
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
		try {
			// get 'mark as read' from URL parameter (?read=1)
			$mark_as_read = Input::get('read');

			// get thread info by users_thread id
			$thread = ThreadsService::getThreadInfoByUsersThreadId($id, $mark_as_read);
			return Responder::success($thread);
		} catch (Exception $e) {
			return Responder::failureMessage('Error: ' . $e->getMessage());
		}
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
