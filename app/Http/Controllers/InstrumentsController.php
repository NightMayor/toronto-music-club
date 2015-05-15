<?php namespace App\Http\Controllers;

use Auth;
use Exception;

use App\Instrument;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\InstrumentsService;
use App\Services\Responder as Responder;

use Illuminate\Http\Request;

class InstrumentsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		try {
			$instruments = InstrumentsService::getAllInstruments();

			$data = [
				'instruments' => $instruments,
			];

			return Responder::success($data);
		} catch (Exception $e) {
			return Responder::failureMessage('Error: Could not retrieve instruments');
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
			InstrumentsService::updateUsersInstruments(Auth::id());

			return Responder::successMessage('Success: Your instruments have been updated');
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
		//
	}

}
