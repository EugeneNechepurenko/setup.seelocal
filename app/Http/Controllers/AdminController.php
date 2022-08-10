<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Campaign_Objective;
use App\Campaign_Plan;
use Illuminate\Http\Request;
use Auth;
use DB;
//use App\Quotation;

use App\Http\Requests;

class AdminController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * @return string
     */
    public function getCampaign(){
       $res = Campaign::all()->toJson();
    }
//
//    public function saveCampaign(Request $request){
//        $data = json_decode($request->getContent());
//        $user = Auth::User();
//        $userId = $user->id;
////        print_r($data);
//
//        $compaing_master_id = DB::table('campaign_master')->insertGetId(
//            [
//                'campaign_name' => $data->campaign_name,
//                'campaign_plan' => $data->campaign_plan,
//                'objective' => $data->campaign_objective,
//                'campaign_logo' => 'logo.png',
//                'campaign_timeframe' => $data->campaign_period,
//                'campaign_start_date' => $data->campaign_start_date,
//                'campaign_end_date' => $data->campaign_end_date,
//                'campaign_price' => $data->campaign_price,
//                'campaign_phone' => $data->campaign_phone,
//                'fullname' => $data->fullName,
//                'street' => $data->street,
//                'apt_suite' => '',
//                'city' => $data->city,
//                'postal_code' => $data->postcode,
//                'state_code' => '',
//                'country_code' => $data->country,
//                'created_date' => '',
//                'created_by' => $userId,
//                'modified_date' => '',
//                'modified_by' => '',
//                'status' => '',
//
//            ]
//        );
//        print_r($compaing_master_id);
//     /*   securityCode
//        cardNumber
//        expiryDate
//        cardType
//        houseNumber
//
//        campaign_objective
//        campaign_objective_name
//        campaign_name
//        campaign_phone
//        campaign_locations
//        campaign_age
//        campaign_gender
//        campaign_languages
//        campaign_interests
//        campaign_keywords
//        campaign_websites
//        campaign_promotion*/
//
//
////        exit;
//     return response( 'ok' );
//    }


    public function doPayment(){

    }

}
