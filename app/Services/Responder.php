<?php namespace App\Services;

use Illuminate\Http\JsonResponse;

class Responder {

	public static function success($data = array(), $message = 'Success', $status = 200, array $headers = array(), $options = 0)
	{
		if ($data instanceof Arrayable)
		{
			$data = $data->toArray();
		}

		$response = [
			'error' => false,
			'message' => $message,
			'data' => $data,
		];

		return new JsonResponse($response, $status, $headers, $options);
	}

	public static function successMessage($message = 'Success', $status = 200, array $headers = array(), $options = 0)
	{
		$response = [
			'error' => false,
			'message' => $message,
		];

		return new JsonResponse($response, $status, $headers, $options);
	}

	public static function failure($data = array(), $message = 'Error', $status = 200, array $headers = array(), $options = 0)
	{
		if ($data instanceof Arrayable)
		{
			$data = $data->toArray();
		}

		$response = [
			'error' => true,
			'message' => $message,
			'data' => $data,
		];

		return new JsonResponse($response, $status, $headers, $options);
	}

	public static function failureMessage($message = 'Error', $status = 200, array $headers = array(), $options = 0)
	{
		$response = [
			'error' => true,
			'message' => $message,
		];

		return new JsonResponse($response, $status, $headers, $options);
	}
}
