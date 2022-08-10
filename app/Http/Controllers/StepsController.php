<?php

namespace App\Http\Controllers;

use App\Campaign_Interest;
use App\Campaign_Objective;
use App\Campaign_Plan;
use Illuminate\Http\Request;
use Auth;
use DB;
use Storage;
use File;
//use App\Quotation;

use App\Http\Requests;

class StepsController extends Controller
{

	public function __construct(){
		$this->middleware('auth');
	}

	/**
	 * @return string
	 */
	public function getObjectives(){




// Confirm
		$html = '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>seelocal | Confirmation</title> 

<link href=\'https://fonts.googleapis.com/css?family=Lato:400,600,700,300\' rel=\'stylesheet\' type=\'text/css\'>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">   
      <style> 
        @media only screen and (min-width: 640px) {
          td>img[class="logo"] {
            width: 350px!important;
          }
          table[class="t83"] {
            width: 83%!important;
          }
            table[class="t82"] {
            width: 82%!important;
          }
            table[class="t85"] {
            width: 85%!important;
          }
            table[class="t74"] {
            width: 74%!important;
          }
            table[class="t78"] {
            width: 78%!important;
          }
            table[class="t95"] {
            width: 95%!important;
          }
             table[class="t75"] {
            width: 75%!important;
          }
             table[class="t90"] {
            width: 90%!important;
          }
            table[class="t93"] {
            width: 93%!important;
          }
            td[class="pl5"] {
              padding-left: 5%!important;
            }
          td[class="pl11"] {
              padding-left: 11%!important;
            }
            
        }

        @media only screen and (max-width: 1900px) {
          td[class="table-text"] {
            font-size: 1.25em!important;
          }
        }
       @media only screen and (max-width: 640px) {
          td[class="table-text"] {
            font-size: 1em!important;
          }
        }

        @media only screen and (max-width: 640px) {
          table[class="main"] {
            font-size: 90%!important;
          }
          td[class="title"] {
            font-size: 2.5em!important;
          }
        }
    </style>   
  </head>
  <body style="margin: 0">  
 
    <table class="main" border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; font-size: 100%; color: white; background: white; font-family: Lato, Arial; font-weight: 300 " width="100%"> 
         <thead bgcolor="#4DC01D">

            <tr bgcolor="#4DC01D">
              <td align="right" style=" padding: 1.3%"> 
                <a href="#" target="_blank" style="font-size: 1.1em; font-family: \'Lato\', Arial; font-weight: 300; letter-spacing: 1px; text-decoration: none; color: white; display: block;" >View this email in your browser</a>
              </td>
           </tr>

           <tr bgcolor="#4DC01D">
              <td style=" padding: 0.5em 4.5%"> 
                   <img class="logo" src="http://drive.google.com/uc?export=view&id=0B77LwrVTKM9YMUp2SzdsXzN4Qkk" alt="logo-company" border="0" width="270" style="display:block"> 
              </td>
           </tr>

           <tr bgcolor="#4DC01D">
              <td align="center" class="title" style="font-size: 2.9em; font-family: \'Lato\', Arial; font-weight: 300; padding-top: 5.5%; padding-right: 7%; padding-left: 7%; line-height: 1.3em">---, </td>
           </tr>

           <tr bgcolor="#4DC01D">
              <td align="center" class="title" style="font-size: 2.9em; line-height: 1.1em; font-family: \'Lato\', Arial; font-weight: 300; padding-left: 7%; padding-right: 7%"> Thank you for setting up a campaign</td>
           </tr>

           <tr bgcolor="#4DC01D">
              <td align="center" style="line-height: 1.1em;font-size: 1.5em; font-family: \'Lato\', Arial; font-weight: 300; background: #4DC01D;  padding: 15px 7% 35px 7%;">Below are your campaign details, receipt & the next steps </td>
           </tr> 
         </thead>  
         <tbody>
            <tr>
              <td align="center" style="background: white">
                <table border="0" cellpadding="0" cellspacing="0"  class="t82" style="width: 90%; margin: 0 auto; background: white; max-width: 1242px; ">
                  <tr>
                   <td bgcolor="#ffffff" class="pl5" style="color: #252525; font-size: 1.5em; font-family: \'Lato\', Arial; font-weight: 300; padding-top: 2.1em; padding-bottom: 1.4em; margin: 0; color: #252525;">Your campaign details</td>
                   </tr>
                </table>
              </td>
            </tr>

            <tr>
              <td align="center" style="background: white; padding-bottom: 30px;">
                <table border="0" cellpadding="0" cellspacing="0" class="t74" style="width: 90%; background: white; max-width: 1115px; margin: 0 auto;">
                  <tr>
                    <td>
                      <table border="0" cellpadding="0" cellspacing="0" style="border-bottom: 1px dashed  #b7b6b6; width: 100%; font-family: Lato, Arial; font-weight: 300; font-size: 0.95em; color: #252525; padding-top: 0.8em;
    padding-bottom: 0.8em;">
                        <tr>
                          <td style="width: 185px; font-family: Lato; font-weight: 300; color: #252525;">Demographics</td>
                          <td style="font-family: Lato; font-weight: 300; color: #252525;">---</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <table border="0" cellpadding="0" cellspacing="0" style="border-bottom: 1px dashed  #b7b6b6; width: 100%; font-family: Lato, Arial; font-weight: 300; color: #252525; padding-top: 0.8em;
    padding-bottom: 0.8em;">
                        <tr>
                          <td style="width: 185px; font-family: Lato; font-size: 0.95em; font-weight: 300; color: #252525;">Location</td>
                          <td style="font-family: Lato; font-weight: 300; font-size: 0.95em; color: #252525;">---</td>
                         </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <table border="0" cellpadding="0" cellspacing="0" style="border-bottom: 1px dashed  #b7b6b6; width: 100%; font-family: Lato, Arial; font-weight: 300; font-size: 0.95em; color: #252525; padding-top: 0.8em;
    padding-bottom: 0.8em;">
                        <tr>
                          <td style="width: 185px; font-family: Lato; font-weight: 300; color: #252525;">Objective</td>
                          <td style="font-family: Lato; font-weight: 300; color: #252525;">---</td> 
                        </tr>
                      </table>
                    </td>     
                  </tr>
                  <tr>
                    <td>
                      <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; font-family: Lato, Arial; font-weight: 300; font-size: 0.95em; color: #252525; margin-bottom: 0.4em; padding-top: 0.8em;   padding-bottom: 0.8em;">
                        <tr>
                          <td style="width: 185px; font-family: Lato; font-weight: 300; color: #252525;">Promotion</td>
                          <td style="font-family: Lato; font-weight: 300; color: #252525;">---</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
        
           <tr>
              <td align="center" style="background: white">
                <table  bgcolor="#F6F6F6" class="t83" border="0" cellpadding="0" cellspacing="0"  width="95%" style="margin: 0 auto; font-family: Lato, Arial; font-weight: 300; color: #252525; max-width: 1242px;">
                  <tr>
                    <td class="pl5" style="font-size: 1.5em; padding: 1em 0% 1em 2.5%; font-family: Lato; font-weight: 300">
                        Your recent campaign order
                    </td>
                </tr>
                </table>
              </td>
            </tr>

          <tr>
            <td align="center">
              <table bgcolor="#F6F6F6" border="0" cellpadding="0" cellspacing="0" class="t83" style="width: 95%; margin: 0 auto; padding-top: 0.55em; max-width: 1242px;">
                <tr>
                  <td align="center">
                    <table bgcolor="#F6F6F6" border="0" cellpadding="0" cellspacing="0" class="t90" style="width: 97%; margin: 0 auto; font-family: Lato, Arial; font-weight: 300; max-width: 1125px; color: #252525;">                   
                      <tr>
                        <td width="20%" >
                          <table  border="0" cellpadding="0" width="98%" cellspacing="0" style="font-family: Lato, Arial; font-weight: 300; text-align: center;">
                            <tr>
                              <td class="table-text" style="font-size: 0.85em; background: #02516C; color: white; height: 56px;font-family: Lato; font-weight: 300 ">Campaign type</td>
                            </tr>
                            <tr>
                            <td class="table-text" style="font-size: 0.85em; background: white; color: #252525; height: 86px;font-family: Lato; font-weight: 300">---</td>
                            </tr>
                          </table>
                        </td>
                         <td width="20%">
                          <table border="0" cellpadding="0" width="98%" cellspacing="0" style=" font-family: Lato, Arial; max-width: 1132px;font-weight: 300;text-align: center">
                            <tr>
                              <td class="table-text" style="font-size: 0.85em; background: #02516C; color: white; height: 56px;font-family: Lato; font-weight: 300 ">Campaign option</td>
                            </tr>
                            <tr>
                            <td class="table-text" style="font-size: 0.85em; background: white; color: #252525;height: 86px; font-family: Lato; font-weight: 300 ">---</td>
                            </tr>
                          </table >
                        </td>
                         <td width="20%">
                          <table border="0" cellpadding="0" width="98%" cellspacing="0" style=" font-family: Lato, Arial; font-weight: 300; text-align: center">
                            <tr>
                              <td class="table-text" style="font-size: 0.85em; background: #02516C; color: white; font-family: Lato; font-weight: 300; height: 56px; ">Launch & end dates</td>
                            </tr>
                            <tr>
                            <td class="table-text" style="font-size: 0.85em; background: white; font-family: Lato; font-weight: 300; color: #252525;height: 86px">---</td>
                            </tr>
                          </table>
                        </td>
                         <td width="20%">
                          <table border="0" cellpadding="0" width="100%" cellspacing="0" style=" font-family: Lato, Arial; font-weight: 300; text-align: center">
                            <tr>
                              <td class="table-text" style="font-size: 0.85em; font-family: Lato; font-weight: 300; background: #02516C; color: white; height: 56px; ">Cost</td>
                            </tr>
                            <tr>
                            <td class="table-text" style="font-size: 0.85em; background: white; font-family: Lato; color: #4dc01d; font-weight: 600; height: 86px">&pound;---</td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                    </td>
                  </tr>
                 </table>
                </td>
              </tr>

            <tr>
              <td align="center" style="padding-bottom: 15px;">
                <table bgcolor="#F6F6F6" border="0" cellpadding="0" cellspacing="0"  class="t83" style="width: 95%; max-width: 1242px; margin: 0 auto; ">
                  <tr>
                    <td>
                      <table  width="100%" bgcolor="#F6F6F6" border="0" cellpadding="0" cellspacing="0" >                               
                         <tr>
                           <td  class="pl5" style="color: #252525; font-size: 1.5em; font-family: \'Lato\', Arial; font-weight: 300; padding: 1.2em 2.5% 0.7em 2.5%; margin: 0; ">Payment details</td>
                        </tr>
                      </table>
                    </td>
                  </tr>

                  <tr>
                    <td align="center" style="padding-bottom: 25px;">
                      <table border="0" cellpadding="0" cellspacing="0" class="t90" width="95%" style="margin: 0 auto">
                        <tr>
                          <td>
                          <table  bgcolor="#F6F6F6" border="0" cellpadding="0" cellspacing="0" style="border-bottom: 1px dashed  #b7b6b6; width: 100%; font-family: Lato, Arial; font-weight: 300; font-size: 0.95em; max-width: 562px; color: #252525; padding-bottom: 0.8em; padding-top: 0.8em">
                            <tr>
                              <td style="width: 210px; padding-right: 4%; font-family: Lato; font-weight: 300">Cardholders name</td>
                              <td style="font-family: Lato; font-weight: 300">---</td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <table  bgcolor="#F6F6F6" border="0" cellpadding="0" cellspacing="0" style="border-bottom: 1px dashed  #b7b6b6; width: 100%; font-family: Lato, Arial; font-weight: 300; font-size: 0.95em; max-width: 562px; color: #252525; padding-bottom: 0.8em; padding-top: 0.8em; font-size: 0.95em">
                            <tr>
                              <td style="width: 210px; padding-right: 4%;font-family: Lato; font-weight: 300">Card number</td>
                              <td style="font-family: Lato; font-weight: 300">---</td>
                             </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <table   bgcolor="#F6F6F6" border="0" cellpadding="0" cellspacing="0" style="width: 100%; font-family: Lato, Arial; font-weight: 300; font-size: 0.95em; color: #252525; max-width: 562px; padding-bottom: 0.8em; padding-top: 0.8em;">
                            <tr>
                              <td style="width: 210px; padding-right: 4%;font-family: Lato; font-weight: 300">Expiry date</td>
                              <td style="font-family: Lato; font-weight: 300">---</td> 
                            </tr>
                          </table>
                        </td>     
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
                </td>
              </tr>
            </tbody>
          </table>
      <!--   </td>
      </tr>  -->
      <table width="100%" style="background: white" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" style="padding-top: 2.5em; padding-bottom: 2.5em">
          <table border="0" cellpadding="0" cellspacing="0" class="t75" style="width: 90%; margin: 0 auto; color: #252525; font-family: Lato, Arial; font-weight: 300; background:white; max-width: 1115px; ">
            <tr style="">
               <td style="color: #252525; font-size: 1.5em; padding-bottom:  25px; font-family: Lato; font-weight: 300">What happens next?</td>          
             </tr>
             <tr>
               <td style="color: #252525; font-size: 0.95em; line-height: 1.5em; font-family: Lato; font-weight: 300">
               In the next 1-2 working days we will send you a set of 6 display ads using the images and content that you provided,
we will also send a link to your landing page. 
              </td>
             </tr>
             <tr>
               <td style="color: #252525; font-size: 0.95em; line-height: 1.5em; padding-top: 25px; font-family: Lato; font-weight: 300">If you don`t receive anything from us, please contact us on <a style="color: #4dc01d; text-decoration: none; white-space: nowrap" href="tel:01295817638"> 01295 817 638</a></td>
             </tr>  
               </table>
             </td>
       </tr>

            <tr bgcolor="#02516C">
              <td align="center" bgcolor="#02516C" style="font-size: 1.5em; font-family: \'Lato\', Arial; font-weight: 300; padding: 1.5em 7% 0.7em 7%; margin: 0; color: white">Thanks, from the Seelocal team 
              </td>
            </tr>
            <tr bgcolor="#02516C">
              <td align="center" bgcolor="#02516C" style="color: white; font-family: \'Lato\', Arial; font-weight: 300; font-size: 0.95em; line-height: 1.1em; padding: 5px 7% 2.7em 7%">
                If you have any questions regarding your campaign get in touch with a member of our team on <span style="white-space: nowrap">01295 817 638</span>
              </td>
            </tr>
            <tr bgcolor="#424041">
              <td  align="center" style="color: white; font-family: \'Lato\', Arial;font-weight: 300; font-size: 0.85em; padding: 1.25em 7%">
                 Copyright &copy; 2016, SeeLocal Ltd, All rights reserved
              </td>
            </tr> 
    </table> 
  </body>
</html>
';


		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Seelocal <admin@setup-campaign.seelocal.co.uk>' . "\r\n";
		$headers .= 'X-Mailer: PHP/' . phpversion();
//        if( mail('alex.bury@seelocal.co.uk', 'Confirm campaign', $html, $headers) ){}
//        if( mail('djstreet11@outlook.com', 'Confirm campaign', $html, $headers) ){}






		return Campaign_Objective::all()->toJson();
	}

	/**
	 * @return string
	 */
	public function getInterests(){
		return Campaign_Interest::all()->toJson();
	}

	/**
	 * @return string
	 */
	public function getPlans(){
		return Campaign_Plan::all()->toJson();
	}


	public function uploadImages(Request $request){
		return $request->file();
	}

	public function moveImagesFromTemp($images){
		foreach($images as $image){
			rename(public_path() . 'images/temp/'. $image, public_path() . 'images/uploads/' . $image);
		}

		if ($handle = opendir(public_path() .'images/temp/')) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					unlink(public_path() .'images/temp/'. $file);
				}
			}
			closedir($handle);
		}

	}



	public function pay(Request $request){
		$data = json_decode($request->getContent());
		$tmp = new PayController();

		$coupon = (isset($data->coupon_code)) ? $data->coupon_code : '';

		if($coupon == 'SeeLocalf33!'){
		    $f = fopen('/var/www/html/app/Http/Controllers/log.txt','a+'); fwrite($f,"\n coupon = '$coupon' , user_id = '".Auth::User()->id."' ");fclose($f);
			return array(
				'transaction_id'=>'00000000000000000',
				'status'=>'Success',
				'msg'=>''
			);
		}
		if ( Auth::User()->id == 145 ||  Auth::User()->id == 52) {
            $f = fopen('/var/www/html/app/Http/Controllers/log.txt','a+'); fwrite($f,"\n coupon = '$coupon' , user_id = '".Auth::User()->id."' ");fclose($f);
			return array(
				'transaction_id'=>'00000000000000000',
				'status'=>'Success',
				'msg'=>''
			);
		}

		if ( $data->campaign_period != '1' ) {
		    $res = $tmp->data_for_pay($data);
            $data_json = json_encode($data);
            $res_json = json_encode($res);
		    $f = fopen('/var/www/html/app/Http/Controllers/log.txt','a+');
            fwrite($f,"\n coupon = '{$coupon}' , user_id = '".Auth::User()->id."' , data->campaign_period != '1' , data = '{$data_json}' , res = '{$res_json}' ");
            fclose($f);
			return response( $res );
		} else {
            $res = $tmp->get_pay_method_subscription($data);
            $data_json = json_encode($data);
            $res_json = json_encode($res);
            $f = fopen('/var/www/html/app/Http/Controllers/log.txt','a+');
            fwrite($f,"\n coupon = '{$coupon}' , user_id = '".Auth::User()->id."' , data->campaign_period != '1' , data = '{$data_json}' , res = '{$res_json}' ");
            fclose($f);
			return response( $res );
		}
	}






	public function saveCampaign(Request $request){
//return '';

		$data = json_decode($request->getContent());

		if ( $data->campaign_period == 1 ) {
			if ( $data->campaign_plan == 1 ) {
				$mounth_plus = 3;
			} else if ( $data->campaign_plan == 2 ) {
				$mounth_plus = 6;
			} else if ( $data->campaign_plan == 3 ) {
				$mounth_plus = 9;
			} else if ( $data->campaign_plan == 4 ) {
				$mounth_plus = 12;
			}
			// $start_date_tmp = new \DateTime($data->campaign_start_date);
			$end_date_tmp = new \DateTime($data->campaign_start_date);
			$end_date_tmp->add( new \DateInterval('P'.$mounth_plus.'M'));
			$data->campaign_end_date = $end_date_tmp->format('Y-m-d');
		}

		$user = Auth::User();
		$userId = $user->id;




// convert from array to list with separate "," START
		$keywords = $data->campaign_keywords;
		$tmp = '';
		for ($i=0; $i < sizeof($keywords); ++$i) {
			if($i == sizeof($keywords)-1) $tmp .= $keywords[$i]->name;
			else $tmp .= $keywords[$i]->name.',';
		}
		$keywords = $tmp;

		$interests = $data->campaign_interests;
		$tmp = '';
		for ($i=0; $i < sizeof($interests); ++$i) {
			if($i == sizeof($interests)-1) $tmp .= $interests[$i]->name;
			else $tmp .= $interests[$i]->name.',';
		}
		$interests = $tmp;

		$websites = $data->campaign_websites;
		$tmp = '';
		for ($i=0; $i < sizeof($websites); ++$i) {
			if($i == sizeof($websites)-1) $tmp .= $websites[$i]->name;
			else $tmp .= $websites[$i]->name.',';
		}
		$websites = $tmp;

		$campaign_jb_target = $data->campaign_jb_target;
		$tmp = '';
		for ($i=0; $i < sizeof($campaign_jb_target); ++$i) {
			if($i == sizeof($campaign_jb_target)-1) $tmp .= $campaign_jb_target[$i]->name;
			else $tmp .= $campaign_jb_target[$i]->name.',';
		}
		$campaign_jb_target = $tmp;
// convert from array to list with separate "," END

		$data_img = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data->campaign_logo));
		$name_img = uniqid().$data->campaign_logo_img_name;
		Storage::disk('uploads')->put($name_img, $data_img);


		$tmp = (string) $name_img;

		$compaing_master_id = DB::table('campaign_master')->insertGetId(
			[
				'campaign_name' => $data->campaign_name,
				'campaign_plan' => $data->campaign_plan,
				'objective' => $data->campaign_objective,
				'campaign_logo' => $tmp,
				'campaign_text' => $data->campaign_promotion,
				'campaign_timeframe' => $data->campaign_period,
				'campaign_start_date' => $data->campaign_start_date,
				'campaign_end_date' => $data->campaign_end_date,
				'campaign_price' => $data->campaign_price,
				'campaign_phone' => $data->campaign_phone,
				'fullname' => $data->fullName,
				'street' => $data->street,
				'apt_suite' => $data->houseNumber,
				'city' => $data->city,
				'postal_code' => $data->postcode,
				'state_code' => '-',
				'country_code' => $data->country,
				'created_date' => date('Y-m-d H:i:s'),
				'created_by' => $userId,
//                'modified_date' => '',
				'modified_by' => '',
				'status' => '0',

			]
		);


// campaing type
		$campaign_type_id = DB::table('campaign_type')->insertGetId(
			[
				'campaign_id' => $compaing_master_id,
				'type' => '',
				'age_from' => $data->campaign_age_from,
				'age_to' => $data->campaign_age_to,
				'gender' => $data->campaign_gender,
				'languages' => $data->campaign_languages,
				'topics' => '',
				'relationships' => $data->campaign_rel_status,
				'work' => $campaign_jb_target,
				'keywords' => $keywords,
				'placements' => $websites,
				'interests' => $interests,

			]
		);

// order
		$order_id = DB::table('orders')->insertGetId(
			[
				'campaign_id' => $compaing_master_id,
				'user_id' => $userId,
				'transection_id' => $data->transaction_id,
				'price' => $data->campaign_price,
				'payment_status' => '1', // 1 -sucessfull,0-unsucessful
			]
		);



// locations of campaing
		for ($i=0; $i < sizeof($data->campaign_locations); $i++) {

			if(isset($data->campaign_locations[$i]->postcode)){
				$postcode = $data->campaign_locations[$i]->postcode;
			}else{
				$postcode = '';
			}

			DB::table('campaign_locations')->insert(
				[
					'campaign_type_id' => $campaign_type_id,
					'location' => $data->campaign_locations[$i]->location,
					'target_city' => $data->campaign_locations[$i]->cities,
					'postcode' => $postcode,
					'mile_radius' => $data->campaign_locations[$i]->radius,
				]
			);
		}

// images of campaing


		if($data->use_coupon == 'yes') {
			DB::connection('user_steps')->table('users_with_coupons')->insert(['user_id' => Auth::user()->id]);
		}


		for ($i=0; $i < sizeof($data->campaign_images); $i++) {

			if($data->campaign_images[$i]->name) {


				$data_img = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data->campaign_images[$i]->src));
				$name_img = uniqid().$data->campaign_images[$i]->name;
				Storage::disk('uploads')->put($name_img, $data_img);

				DB::table('campaign_images')->insert(
					[
						'campaign_id' => $compaing_master_id,
						'image' => $name_img
					]
				);
			}
		}



		$last_data = DB::connection('user_steps')->table('user_info')->where('user_id', $userId)->get();

		if(DB::connection('user_steps')->table('history_orders')->where('user_id', $userId)->get()){
			DB::connection('user_steps')->table('history_orders')->where('user_id', $last_data[0]->user_id)->update(['user_info'=>$last_data[0]->user_info]);
		}else{
			DB::connection('user_steps')->table('history_orders')->insert(['user_info'=>$last_data[0]->user_info, 'user_id'=>$last_data[0]->user_id]);
		}

        DB::connection('user_steps')->table('user_info')->where('user_id', $userId)->delete();


		$prices = array(array("299","499","899","1,749"),array("299","459","839","1,649"),array("149"));


		$name_line = $data->fullName;
		$campaing_obj = array('','Ad Placement','Brand Awareness','Sales','Customer Enquiries','Events','Video Views');
		$campaing_types = array('Single Campaign','Subscription Campaigns','Other Campaigns');
		$campaing_options = array( array('Start','Advanced','Expert','VIP'), array('Start','Advanced','Expert','VIP'), array('brand awareness','beacon','self-serve') );

		$campaing_timeframe = $data->campaign_period;
		$campaing_plan = $data->campaign_plan;

		$gender = $data->campaign_gender;
		$gender = ($gender == 'all')? 'Male & Female' : ( ($gender == 'male')? 'Male' : ( ($gender == 'female')? 'Female' : 'all' ) );
		$demografics_line = $gender.', '.$data->campaign_age_from.'-'.$data->campaign_age_to;

		for ($i=0; $i < sizeof($data->campaign_locations); $i++) {
			if($i == sizeof($websites)-1) $location_line = $data->campaign_locations[$i]->cities.' + '.$data->campaign_locations[$i]->radius.' Mile Radius';
			else $location_line = $data->campaign_locations[$i]->cities.' + '.$data->campaign_locations[$i]->radius.' Mile Radius, ';
		}

		$objectve_line = $campaing_obj[$data->campaign_objective];

		$promotion_line = $data->campaign_promotion;
		$camp_start = $data->campaign_start_date;
		$camp_end = $data->campaign_end_date;
		$pay_fullname = $data->fullName;
		$pay_card = 'XXXX-XXXX-XXXX-'.substr($data->cardNumber, -4);
		$pay_exp_date = $data->cardNumber;
		$campaing_price = $data->cardNumber;



		$campaing_type = $campaing_types[$campaing_timeframe];
		$campaing_option = $campaing_options[(int)$campaing_timeframe][(int)$campaing_plan-1];
		$campaing_dates = $camp_start.' - '.$camp_end;
//        return response( $campaing_plan );
		$campaing_price = $prices[(int)$campaing_timeframe][(int)$campaing_plan-1];

		$payment_name = $pay_fullname;
		$payment_card_number = $pay_card;
		$payment_exp_date = $pay_card;



		$in_browser = base64_encode(json_encode(
				array(
					'name_line'=>$name_line,
					'demografics_line' => $demografics_line,
					'location_line' => $location_line,
					'objectve_line' => $objectve_line,
					'promotion_line' => $promotion_line,
					'campaing_type' => $campaing_type,
					'campaing_option' => $campaing_option,
					'campaing_dates' => $campaing_dates,
					'campaing_price' => $campaing_price,
					'payment_name' => $payment_name,
					'payment_card_number' => $payment_card_number,
					'payment_exp_date' => $payment_exp_date
				))
		);
// Confirm
		$html = '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>seelocal | Confirmation</title> 

<link href=\'https://fonts.googleapis.com/css?family=Lato:400,600,700,300\' rel=\'stylesheet\' type=\'text/css\'>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">   
      <style> 
        @media only screen and (min-width: 640px) {
          td>img[class="logo"] {
            width: 350px!important;
          }
          table[class="t83"] {
            width: 83%!important;
          }
            table[class="t82"] {
            width: 82%!important;
          }
            table[class="t85"] {
            width: 85%!important;
          }
            table[class="t74"] {
            width: 74%!important;
          }
            table[class="t78"] {
            width: 78%!important;
          }
            table[class="t95"] {
            width: 95%!important;
          }
             table[class="t75"] {
            width: 75%!important;
          }
             table[class="t90"] {
            width: 90%!important;
          }
            table[class="t93"] {
            width: 93%!important;
          }
            td[class="pl5"] {
              padding-left: 5%!important;
            }
          td[class="pl11"] {
              padding-left: 11%!important;
            }
            
        }

        @media only screen and (max-width: 1900px) {
          td[class="table-text"] {
            font-size: 1.25em!important;
          }
        }
       @media only screen and (max-width: 640px) {
          td[class="table-text"] {
            font-size: 1em!important;
          }
        }

        @media only screen and (max-width: 640px) {
          table[class="main"] {
            font-size: 90%!important;
          }
          td[class="title"] {
            font-size: 2.5em!important;
          }
        }
    </style>   
  </head>
  <body style="margin: 0">  
 
    <table class="main" border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; font-size: 100%; color: white; background: white; font-family: Lato, Arial; font-weight: 300 " width="100%"> 
         <thead bgcolor="#4DC01D">

            <tr bgcolor="#4DC01D">
              <td align="right" style=" padding: 1.3%"> 
                <a href="https://setup-campaign.seelocal.co.uk/mail/confirm?'.$in_browser.'" target="_blank" style="font-size: 1.1em; font-family: \'Lato\', Arial; font-weight: 300; letter-spacing: 1px; text-decoration: none; color: white; display: block;" >View this email in your browser</a>
              </td>
           </tr>

           <tr bgcolor="#4DC01D">
              <td style=" padding: 0.5em 4.5%"> 
                   <img class="logo" src="http://drive.google.com/uc?export=view&id=0B77LwrVTKM9YMUp2SzdsXzN4Qkk" alt="logo-company" border="0" width="270" style="display:block"> 
              </td>
           </tr>

           <tr bgcolor="#4DC01D">
              <td align="center" class="title" style="font-size: 2.9em; font-family: \'Lato\', Arial; font-weight: 300; padding-top: 5.5%; padding-right: 7%; padding-left: 7%; line-height: 1.3em">'.$name_line.', </td>
           </tr>

           <tr bgcolor="#4DC01D">
              <td align="center" class="title" style="font-size: 2.9em; line-height: 1.1em; font-family: \'Lato\', Arial; font-weight: 300; padding-left: 7%; padding-right: 7%"> Thank you for setting up a campaign</td>
           </tr>

           <tr bgcolor="#4DC01D">
              <td align="center" style="line-height: 1.1em;font-size: 1.5em; font-family: \'Lato\', Arial; font-weight: 300; background: #4DC01D;  padding: 15px 7% 35px 7%;">Below are your campaign details, reciept & the next steps </td>
           </tr> 
         </thead>  
         <tbody>
            <tr>
              <td align="center" style="background: white">
                <table border="0" cellpadding="0" cellspacing="0"  class="t82" style="width: 90%; margin: 0 auto; background: white; max-width: 1242px; ">
                  <tr>
                   <td bgcolor="#ffffff" class="pl5" style="color: #252525; font-size: 1.5em; font-family: \'Lato\', Arial; font-weight: 300; padding-top: 2.1em; padding-bottom: 1.4em; margin: 0; color: #252525;">Your campaign details</td>
                   </tr>
                </table>
              </td>
            </tr>

            <tr>
              <td align="center" style="background: white; padding-bottom: 30px;">
                <table border="0" cellpadding="0" cellspacing="0" class="t74" style="width: 90%; background: white; max-width: 1115px; margin: 0 auto;">
                  <tr>
                    <td>
                      <table border="0" cellpadding="0" cellspacing="0" style="border-bottom: 1px dashed  #b7b6b6; width: 100%; font-family: Lato, Arial; font-weight: 300; font-size: 0.95em; color: #252525; padding-top: 0.8em;
    padding-bottom: 0.8em;">
                        <tr>
                          <td style="width: 185px; font-family: Lato; font-weight: 300; color: #252525;">Demographics</td>
                          <td style="font-family: Lato; font-weight: 300; color: #252525;">'.$demografics_line.'</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <table border="0" cellpadding="0" cellspacing="0" style="border-bottom: 1px dashed  #b7b6b6; width: 100%; font-family: Lato, Arial; font-weight: 300; color: #252525; padding-top: 0.8em;
    padding-bottom: 0.8em;">
                        <tr>
                          <td style="width: 185px; font-family: Lato; font-size: 0.95em; font-weight: 300; color: #252525;">Location</td>
                          <td style="font-family: Lato; font-weight: 300; font-size: 0.95em; color: #252525;">'.$location_line.'</td>
                         </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <table border="0" cellpadding="0" cellspacing="0" style="border-bottom: 1px dashed  #b7b6b6; width: 100%; font-family: Lato, Arial; font-weight: 300; font-size: 0.95em; color: #252525; padding-top: 0.8em;
    padding-bottom: 0.8em;">
                        <tr>
                          <td style="width: 185px; font-family: Lato; font-weight: 300; color: #252525;">Objective</td>
                          <td style="font-family: Lato; font-weight: 300; color: #252525;">'.$objectve_line.'</td> 
                        </tr>
                      </table>
                    </td>     
                  </tr>
                  <tr>
                    <td>
                      <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; font-family: Lato, Arial; font-weight: 300; font-size: 0.95em; color: #252525; margin-bottom: 0.4em; padding-top: 0.8em;   padding-bottom: 0.8em;">
                        <tr>
                          <td style="width: 185px; font-family: Lato; font-weight: 300; color: #252525;">Promotion</td>
                          <td style="font-family: Lato; font-weight: 300; color: #252525;">'.$promotion_line.'</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
        
           <tr>
              <td align="center" style="background: white">
                <table  bgcolor="#F6F6F6" class="t83" border="0" cellpadding="0" cellspacing="0"  width="95%" style="margin: 0 auto; font-family: Lato, Arial; font-weight: 300; color: #252525; max-width: 1242px;">
                  <tr>
                    <td class="pl5" style="font-size: 1.5em; padding: 1em 0% 1em 2.5%; font-family: Lato; font-weight: 300">
                        Your recent campaign order
                    </td>
                </tr>
                </table>
              </td>
            </tr>

          <tr>
            <td align="center">
              <table bgcolor="#F6F6F6" border="0" cellpadding="0" cellspacing="0" class="t83" style="width: 95%; margin: 0 auto; padding-top: 0.55em; max-width: 1242px;">
                <tr>
                  <td align="center">
                    <table bgcolor="#F6F6F6" border="0" cellpadding="0" cellspacing="0" class="t90" style="width: 97%; margin: 0 auto; font-family: Lato, Arial; font-weight: 300; max-width: 1125px; color: #252525;">                   
                      <tr>
                        <td width="20%" >
                          <table  border="0" cellpadding="0" width="98%" cellspacing="0" style="font-family: Lato, Arial; font-weight: 300; text-align: center;">
                            <tr>
                              <td class="table-text" style="font-size: 0.85em; background: #02516C; color: white; height: 56px;font-family: Lato; font-weight: 300 ">Campaign type</td>
                            </tr>
                            <tr>
                            <td class="table-text" style="font-size: 0.85em; background: white; color: #252525; height: 86px;font-family: Lato; font-weight: 300">'.$campaing_type.'</td>
                            </tr>
                          </table>
                        </td>
                         <td width="20%">
                          <table border="0" cellpadding="0" width="98%" cellspacing="0" style=" font-family: Lato, Arial; max-width: 1132px;font-weight: 300;text-align: center">
                            <tr>
                              <td class="table-text" style="font-size: 0.85em; background: #02516C; color: white; height: 56px;font-family: Lato; font-weight: 300 ">Campaign option</td>
                            </tr>
                            <tr>
                            <td class="table-text" style="font-size: 0.85em; background: white; color: #252525;height: 86px; font-family: Lato; font-weight: 300 ">'.$campaing_option.'</td>
                            </tr>
                          </table >
                        </td>
                         <td width="20%">
                          <table border="0" cellpadding="0" width="98%" cellspacing="0" style=" font-family: Lato, Arial; font-weight: 300; text-align: center">
                            <tr>
                              <td class="table-text" style="font-size: 0.85em; background: #02516C; color: white; font-family: Lato; font-weight: 300; height: 56px; ">Launch & end dates</td>
                            </tr>
                            <tr>
                            <td class="table-text" style="font-size: 0.85em; background: white; font-family: Lato; font-weight: 300; color: #252525;height: 86px">'.$campaing_dates.'</td>
                            </tr>
                          </table>
                        </td>
                         <td width="20%">
                          <table border="0" cellpadding="0" width="100%" cellspacing="0" style=" font-family: Lato, Arial; font-weight: 300; text-align: center">
                            <tr>
                              <td class="table-text" style="font-size: 0.85em; font-family: Lato; font-weight: 300; background: #02516C; color: white; height: 56px; ">Cost</td>
                            </tr>
                            <tr>
                            <td class="table-text" style="font-size: 0.85em; background: white; font-family: Lato; color: #4dc01d; font-weight: 600; height: 86px">&pound;'.$campaing_price.'</td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                    </td>
                  </tr>
                 </table>
                </td>
              </tr>

            <tr>
              <td align="center" style="padding-bottom: 15px;">
                <table bgcolor="#F6F6F6" border="0" cellpadding="0" cellspacing="0"  class="t83" style="width: 95%; max-width: 1242px; margin: 0 auto; ">
                  <tr>
                    <td>
                      <table  width="100%" bgcolor="#F6F6F6" border="0" cellpadding="0" cellspacing="0" >                               
                         <tr>
                           <td  class="pl5" style="color: #252525; font-size: 1.5em; font-family: \'Lato\', Arial; font-weight: 300; padding: 1.2em 2.5% 0.7em 2.5%; margin: 0; ">Payment details</td>
                        </tr>
                      </table>
                    </td>
                  </tr>

                  <tr>
                    <td align="center" style="padding-bottom: 25px;">
                      <table border="0" cellpadding="0" cellspacing="0" class="t90" width="95%" style="margin: 0 auto">
                        <tr>
                          <td>
                          <table  bgcolor="#F6F6F6" border="0" cellpadding="0" cellspacing="0" style="border-bottom: 1px dashed  #b7b6b6; width: 100%; font-family: Lato, Arial; font-weight: 300; font-size: 0.95em; max-width: 562px; color: #252525; padding-bottom: 0.8em; padding-top: 0.8em">
                            <tr>
                              <td style="width: 210px; padding-right: 4%; font-family: Lato; font-weight: 300">Cardholders name</td>
                              <td style="font-family: Lato; font-weight: 300">'.$payment_name.'</td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <table  bgcolor="#F6F6F6" border="0" cellpadding="0" cellspacing="0" style="border-bottom: 1px dashed  #b7b6b6; width: 100%; font-family: Lato, Arial; font-weight: 300; font-size: 0.95em; max-width: 562px; color: #252525; padding-bottom: 0.8em; padding-top: 0.8em; font-size: 0.95em">
                            <tr>
                              <td style="width: 210px; padding-right: 4%;font-family: Lato; font-weight: 300">Card number</td>
                              <td style="font-family: Lato; font-weight: 300">'.$payment_card_number.'</td>
                             </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <table   bgcolor="#F6F6F6" border="0" cellpadding="0" cellspacing="0" style="width: 100%; font-family: Lato, Arial; font-weight: 300; font-size: 0.95em; color: #252525; max-width: 562px; padding-bottom: 0.8em; padding-top: 0.8em;">
                            <tr>
                              <td style="width: 210px; padding-right: 4%;font-family: Lato; font-weight: 300">Expiry date</td>
                              <td style="font-family: Lato; font-weight: 300">'.$payment_exp_date.'</td> 
                            </tr>
                          </table>
                        </td>     
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
                </td>
              </tr>
            </tbody>
          </table>
      <!--   </td>
      </tr>  -->
      <table width="100%" style="background: white" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" style="padding-top: 2.5em; padding-bottom: 2.5em">
          <table border="0" cellpadding="0" cellspacing="0" class="t75" style="width: 90%; margin: 0 auto; color: #252525; font-family: Lato, Arial; font-weight: 300; background:white; max-width: 1115px; ">
            <tr style="">
               <td style="color: #252525; font-size: 1.5em; padding-bottom:  25px; font-family: Lato; font-weight: 300">What happens next?</td>          
             </tr>
             <tr>
               <td style="color: #252525; font-size: 0.95em; line-height: 1.5em; font-family: Lato; font-weight: 300">
               In the next 1-2 working days we will send you a set of 6 display ads using the images and content that you provided,
we will also send a link to your landing page. 
              </td>
             </tr>
             <tr>
               <td style="color: #252525; font-size: 0.95em; line-height: 1.5em; padding-top: 25px; font-family: Lato; font-weight: 300">If you don`t recieve anything from us, please contact us on <a style="color: #4dc01d; text-decoration: none; white-space: nowrap" href="tel:01295817638"> 01295 817 638</a></td>
             </tr>  
               </table>
             </td>
       </tr>

            <tr bgcolor="#02516C">
              <td align="center" bgcolor="#02516C" style="font-size: 1.5em; font-family: \'Lato\', Arial; font-weight: 300; padding: 1.5em 7% 0.7em 7%; margin: 0; color: white">Thanks, from the Seelocal team 
              </td>
            </tr>
            <tr bgcolor="#02516C">
              <td align="center" bgcolor="#02516C" style="color: white; font-family: \'Lato\', Arial; font-weight: 300; font-size: 0.95em; line-height: 1.1em; padding: 5px 7% 2.7em 7%">
                If you have any questions regarding your campaign get in touch with a member of our team on <span style="white-space: nowrap">01295 817 638</span>
              </td>
            </tr>
            <tr bgcolor="#424041">
              <td  align="center" style="color: white; font-family: \'Lato\', Arial;font-weight: 300; font-size: 0.85em; padding: 1.25em 7%">
                 Copyright &copy; 2016, SeeLocal Ltd, All rights reserved
              </td>
            </tr> 
    </table> 
  </body>
</html>
';


		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Seelocal <admin@setup-campaign.seelocal.co.uk>' . "\r\n";
		$headers .= 'X-Mailer: PHP/' . phpversion();
		$user = Auth::User();
		$userId = $user->id;
		$user = DB::table('user_management')->select('first_name','email')->where('id','=',$userId)->get();
		if( mail($user[0]->email, 'Confirm campaign', $html, $headers) ){
            $f = fopen('/var/www/html/public/log_debug_eugene.txt','a+');
            fwrite($f," ".date('Y-d-m _ H:i:s')." - send new_campaign_email = ok | userId = '{$userId}','{$user[0]->email}' \n");
            fclose($f);
        }else{
            $f = fopen('/var/www/html/public/log_debug_eugene.txt','a+');
            fwrite($f," ".date('Y-d-m _ H:i:s')." - send new_campaign_email = fail | userId = '{$userId}','{$user[0]->email}' \n");
            fclose($f);
        }

		if( mail('admin@seelocal.co.uk', 'Confirm campaign', $html, $headers) ){
            $f = fopen('/var/www/html/public/log_debug_eugene.txt','a+');
            fwrite($f," ".date('Y-d-m _ H:i:s')." - send new_campaign_email admin = ok | userId = '{$userId}','admin@seelocal.co.uk' \n");
            fclose($f);
        }else{
            $f = fopen('/var/www/html/public/log_debug_eugene.txt','a+');
            fwrite($f," ".date('Y-d-m _ H:i:s')." - send new_campaign_email admin = fail | userId = '{$userId}','admin@seelocal.co.uk' \n");
            fclose($f);
        }


		return response( 'creating_done' );
	}


	public function doPayment(){

	}

	/*
     * function for save user info after click to next or prev step
     * use standart ajax
    */
	public function save_user_info_in_db(Request $request) {
		$data = $request->get('data');
		$array_image = array();
		$user_id = Auth::user()->id;

		$user_info = DB::connection('user_steps')->table('user_info')->where(['user_id' => $user_id])->count();

		if ( $user_info > 0 ) {
			DB::connection('user_steps')->table('user_info')->where('user_id', $user_id)->update(
				array(
					'user_id'       =>  (int)$user_id,
					'user_info'  	=>  json_encode($data),
					'last_activ'	=> 	time()
				));
		} else {
			DB::connection('user_steps')->table('user_info')->insert(
				array(
					'user_id'       =>  (int)$user_id,
					'user_info'  	=>  json_encode($data),
					'last_activ'	=> 	time()
				));
		}
	}

	public function check_is_used_coupon(Request $request){
		$user = DB::connection('user_steps')->table('users_with_coupons')->where(['user_id' => Auth::user()->id])->first();
		if(!$user){ return response( 'no' ); }
		else{ return response( 'yes' ); }
	}
}
