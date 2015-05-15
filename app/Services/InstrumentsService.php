<?php namespace App\Services;

use DB;
use Input;
use Cache;
use Exception;

use App\Instrument;
use App\UsersInstrument;
use App\Services\SubscriptionsService;

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
					$instruments['primary'][] = $users_instrument;
					break;
				
				default:
					$instruments['secondary'][] = $users_instrument;
					break;
			}
		}

		return $instruments;
	}

	public static function updateUsersInstruments($user_id)
	{
		$new_primary = [];
		$new_secondary = [];

		// make sure input is array
		if (is_array(Input::get('primary'))) {
			$new_primary = Input::get('primary');
		}

		// make sure input is array
		if (is_array(Input::get('secondary'))) {
			$new_secondary = Input::get('secondary');
		}

		// get users subscription
		$users_subscription = SubscriptionsService::getSubscriptionByUserId($user_id);

		// make sure they are not over their primary limit
		if (count($new_primary) > $users_subscription[0]->primary_instruments) {
			throw new Exception('Too many Primary Instruments selected. You are allowed to have ' . $users_subscription[0]->primary_instruments);
		}

		// make sure they are not over their secondary limit
		if (count($new_secondary) > $users_subscription[0]->secondary_instruments) {
			throw new Exception('Too many Secondary Instruments selected. You are allowed to have ' . $users_subscription[0]->secondary_instruments);
		}

		// make sure there are no instruments as both primary and secondary
		foreach ($new_primary as $primary_id) {
			
			if (in_array($primary_id, $new_secondary)) {
				throw new Exception('You may not have instruments as both Primary and Secondary Instruments');
			}
		}

		// make sure there are no repeated primary instruments
		if (count($new_primary) != count(array_unique($new_primary))) {
			throw new Exception('You may not have duplicate Primary Instruments');
		}

		// make sure there are no repeated secondary instruments
		if (count($new_secondary) != count(array_unique($new_secondary))) {
			throw new Exception('You may not have duplicate Secondary Instruments');
		}
		
		// get the users current instruments
		$users_instruments = InstrumentsService::getUsersInstruments($user_id);

		// loop through all current primary instruments
		foreach ($users_instruments['primary'] as $primary_instrument) {
		
			// if primary instrument id is in the new primary array...
			if (in_array($primary_instrument->instrument_id, $new_primary)) {
				// remove it from the new primary array
				$new_primary = array_diff($new_primary, array($primary_instrument->instrument_id));
			} else {
				// delete this user instrument
				$instrument_to_delete = UsersInstrument::find($primary_instrument->id);
				$instrument_to_delete->delete();
			}
		}

		// create a new user instrument for every instrument still in new primary array
		foreach ($new_primary as $new_user_instrument) {

			try {
				$instrument_to_create                = new UsersInstrument;
				$instrument_to_create->user_id       = $user_id;
				$instrument_to_create->instrument_id = $new_user_instrument;
				$instrument_to_create->primary       = 1;
				$instrument_to_create->played_since  = 2015;
				$instrument_to_create->save();
			} catch (Exception $e) {
				throw new Exception('Could not add Primary Instrument');
			}
		}

		// loop through all current secondary instruments
		foreach ($users_instruments['secondary'] as $secondary_instrument) {
		
			// if secondary instrument id is in the new secondary array...
			if (in_array($secondary_instrument->instrument_id, $new_secondary)) {
				// remove it from the new secondary array
				$new_secondary = array_diff($new_secondary, array($secondary_instrument->instrument_id));
			} else {
				// delete this user instrument
				$instrument_to_delete = UsersInstrument::find($secondary_instrument->id);
				$instrument_to_delete->delete();
			}
		}

		// create a new user instrument for every instrument still in new secondary array
		foreach ($new_secondary as $new_user_instrument) {
			
			try {
				$instrument_to_create                = new UsersInstrument;
				$instrument_to_create->user_id       = $user_id;
				$instrument_to_create->instrument_id = $new_user_instrument;
				$instrument_to_create->primary       = 0;
				$instrument_to_create->played_since  = 2015;
				$instrument_to_create->save();
			} catch (Exception $e) {
				throw new Exception('Could not add Secondary Instrument');
			}
		}

		// forget the users profile cache
		Cache::forget('profile_' . $user_id);
	}
}
