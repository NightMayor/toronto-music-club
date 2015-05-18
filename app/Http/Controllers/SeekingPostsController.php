<?php namespace App\Http\Controllers;

use Auth;
use Exception;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\SeekingPostsService;
use App\Services\Responder as Responder;

use Illuminate\Http\Request;

class SeekingPostsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		try {
			// get all of the logged in users Seeking Posts
			$seeking_posts = SeekingPostsService::getSeekingPostsByUserId(Auth::id());
			return Responder::success($seeking_posts);
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
			// create a new Seeking Post by the logged in user
			SeekingPostsService::createSeekingPost(Auth::id());
			return Responder::successMessage('Success: Seeking Post created');
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
					// get all seeking posts
					$seeking_posts = SeekingPostsService::getAllSeekingPosts();
					break;
				
				default:
					// get seeking posts by id provided
					$seeking_posts = SeekingPostsService::getSeekingPostsByInstrumentId($id);
					break;
			}
			return Responder::success($seeking_posts);
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
			// delete Seeking Post by the posts id
			SeekingPostsService::deleteSeekingPostByPostId($id);
			return Responder::successMessage('Success: Seeking Post has been deleted');
		} catch (Exception $e) {
			return Responder::failureMessage('Error: ' . $e->getMessage());
		}
	}

}
