<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailAdminPanel extends Model
{

	protected $connection = 'user_steps';

    protected $table = 'timeline';

    protected $fillable = [
        'timeline'
    ];
}
