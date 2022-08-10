<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign_Type extends Model
{
    protected $table = 'campaign_type';

    protected $fillable = [
	'id',
	'campaign_id',
	'gender',
	'languages',
	'keywords',
	'placements',
	'interests',
	'age_to',
	'age_from',
	];
public $timestamps = false;

    public function campaign(){
        return $this->belongsTo('\App\Campaign');
    }

    public function locations(){
        return $this->hasMany('\App\Campaign_Location','campaign_type_id');
    }
}
