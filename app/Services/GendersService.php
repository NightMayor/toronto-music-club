<?php namespace App\Services;

use Cache;
use App\User;
use Exception;
use App\Gender;

class GendersService {

	public static function getAllGenders()
	{
		if (!Cache::has('gender_list')) {
			$genders = Gender::all();
			Cache::put('gender_list', $genders, 10);
		}

		return Cache::get('gender_list');
	}
}