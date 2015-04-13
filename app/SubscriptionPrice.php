<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionPrice extends Model {

	use SoftDeletes;

	protected $dates = ['deleted_at'];

	protected $table = 'subscription_prices';
}
