<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginInfo extends Model
{
    protected $table = 'login_info';

	protected $fillable = [
		'email',
		'status',
		'ip_address',
		'device',
		'platform',
		'browser',
	];
}
