<?php namespace App\Http\Controllers;

use Exception;

use App\Http\Requests;
use App\Services\GendersService;
use App\Http\Controllers\Controller;
use App\Services\Responder as Responder;

use Illuminate\Http\Request;

class GendersController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		try {
			$genders = GendersService::getAllGenders();

			$data = [
				'genders' => $genders,
			];

			return Responder::success($data);
		} catch (Exception $e) {
			return Responder::failureMessage('Error: Could not retrieve genders');
		}
	}
	
}
