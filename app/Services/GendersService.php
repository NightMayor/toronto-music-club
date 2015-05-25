<?php namespace App\Services;

use Cache;
use Exception;

use App\User;
use App\Gender;

class GendersService {

	public static function getAllGenders()
	{
		if (!Cache::has('gender_list')) {
			$genders = Gender::all();
			Cache::put('gender_list', $genders, 10080);
		}

		return Cache::get('gender_list');
	}
}
