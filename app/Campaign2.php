<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign2 extends Model
{
    protected $table = 'campaign_master';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'modified_date';
    
        
    protected $fillable = [
        'id',
        'campaign_name',
        'campaign_phone',
        'campaign_plan',
        'objective',
        'campaign_logo',
        'campaign_text',
        'campaign_price',
        'campaign_timeframe',
        'campaign_start_date',
        'campaign_end_date',

        'fullname',
        'street',
        'apt_suite',
        'city',
        'postal_code',
        'state_code',
        'country_code',
        'created_by',
        'modified_by',
        'status',
    ];
//     public $timestamps = false;
    public function images(){
        return $this->hasMany('\App\Campaign_Image');
    }

    public function type(){
        return $this->hasOne('\App\Campaign_Type');
    }

}


