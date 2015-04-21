<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersInstrument extends Model {

	use SoftDeletes;

	protected $dates = ['deleted_at'];

	protected $table = 'users_instruments';
}
