<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign_Location extends Model
{
    protected $table = 'campaign_locations';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'campaign_type_id', 'location', 'postcode', 'mile_radius'];
	public $timestamps = false;
   /* public function type(){
        return $this->belongsTo('\App\Campaign_Type');
    }*/
	
	
	public function scopewithLoc($query, $contactId)
    {
        $query->whereHas('campaign_locations', function ($q) use ($contactId) {
            $q->where('campaign_type_id', $contactId);
        });
    }
	
	
}
