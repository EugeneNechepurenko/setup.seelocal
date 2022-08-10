<?php
namespace App\Model;
use App\User;
use Illuminate\Database\Eloquent\Model;
class Contact3 extends Model
{
    /**
     * @var string
     */
    protected $table = 'campaign_master';
    /**
     * @var array
     */
    protected $fillable = [
	'campaign_name',
	'campaign_phone',
	'campaign_type',
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
	'status'
    ];
}