<?php namespace App\Services;

use DB;
use Cache;
use Exception;
use App\Instrument;
use App\UsersInstrument;

class InstrumentsService {

	public static function getAllInstruments()
	{
		if (!Cache::has('intruments_list')) {
			$instruments = Instrument::all();
			Cache::put('intruments_list', $instruments, 10);
		}

		return Cache::get('intruments_list');
	}

	public static function getUsersInstruments($user_id)
	{
		// get all the users instruments
		$users_instruments = DB::table('users_instruments')
			->join('instruments', 'users_instruments.instrument_id', '=', 'instruments.id')
			->select('users_instruments.id', 'users_instruments.instrument_id', 'users_instruments.played_since', 'users_instruments.primary', 'instruments.description')
			->where('users_instruments.user_id', $user_id)
			->whereNull('users_instruments.deleted_at')
			->whereNull('instruments.deleted_at')
			->get();

		// initialize instruments array
		$instruments = [
			'primary'   => [],
			'secondary' => [],
		];
		
		// loop through all the users instruments
		foreach ($users_instruments as $users_instrument) {
		
			// label them as either primary or secondary instruments
			switch ($users_instrument->primary) {
				case 1:
					$instruments['primary'] = $users_instrument;
					break;
				
				default:
					$instruments['secondary'][] = $users_instrument;
					break;
			}
		}

		return $instruments;
	}
}
