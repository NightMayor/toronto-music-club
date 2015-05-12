<?php namespace App\Http\Controllers;

use Auth;
use Exception;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AvailablePostsService;
use App\Services\Responder as Responder;

class AvailablePostsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		try {
			// get all of the logged in users Available Posts
			$available_posts = AvailablePostsService::getAvailablePostsByUserId(Auth::id());
			return Responder::success($available_posts);
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
			// create a new Available Post by the logged in user
			AvailablePostsService::createAvailablePost(Auth::id());
			return Responder::successMessage('Success: Available Post created');
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
			switch ($id) {
				case 'All':
					// get all available posts
					$available_posts = AvailablePostsService::getAllAvailablePosts();
					break;
				
				default:
					// get available posts by id provided
					$available_posts = AvailablePostsService::getAvailablePostsByInstrumentId($id);
					break;
			}
			return Responder::success($available_posts);
		} catch (Exception $e) {
			return Responder::failureMessage('Error: ' . $e->getMessage());
		}
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
		//
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
			// delete Available Post by the posts id
			AvailablePostsService::deleteAvailablePostsByPostId($id);
			return Responder::successMessage('Success: Available Post has been deleted');
		} catch (Exception $e) {
			return Responder::failureMessage('Error: ' . $e->getMessage());
		}
	}

}
