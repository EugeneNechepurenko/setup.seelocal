<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class CompaignSettings extends Model {
    public static function saveSettings ($request) {

        $id = $request->id;
        $campaign_master = $request->campaign_master;
        $campaign_type = $request->campaign_type;
        $locations = $request->locations;
        $gallery = $request->gallery;

        if ( $campaign_master['checkTimeRadio'] == 1 ) {
            $campaign_master['finDate'] = '';
			if ( $campaign_master['checkPriceRadio'] == 897 ) {
				$mounth_plus = 3;
			} else if ( $campaign_master['checkPriceRadio'] == 2920 ) {
				$mounth_plus = 6;
			} else if ( $campaign_master['checkPriceRadio'] == 7699 ) {
				$mounth_plus = 9;
			} else if ( $campaign_master['checkPriceRadio'] == 19420 ) {
				$mounth_plus = 12;
			}
			$end_date_tmp = new \DateTime($campaign_master['startDate']);
			$end_date_tmp->add( new \DateInterval('P'.$mounth_plus.'M'));
			$campaign_master['finDate'] = $end_date_tmp->format('Y-m-d');			
        }

//
////        -------------------  campaign_master  ------------------------------
//
        $campaign_name = $campaign_master['campaign_name'];
        $campaign_phone = $campaign_master['campaign_phone'];
        $campaign_manage = $campaign_master['campaign_manage'];
        $promotion = $campaign_master['promotion'];
        $fullname = $campaign_master['fullname'];
        $aptSuite = $campaign_master['aptSuite'];
        $city = $campaign_master['city'];
        $postalCode = $campaign_master['postalCode'];
        $street = $campaign_master['street'];
        $startDate = $campaign_master['startDate'];
        $finDate = $campaign_master['finDate'];
        $checkTimeRadio = $campaign_master['checkTimeRadio'];
        $checkPriceRadio = $campaign_master['checkPriceRadio'];
        $logo = ($campaign_master['logo'] != 'false') ? $campaign_master['logo']: '';

//        -------------------  campaign_type  ------------------------------

        $campaign_age_from = $campaign_type['campaign_age_from'];
        $campaign_age_to = $campaign_type['campaign_age_to'];
        $campaign_languages = $campaign_type['campaign_languages'];
        $gender = $campaign_type['gender'];
        $rel_status = $campaign_type['rel_status'];
        $campaign_jobtitle = $campaign_type['campaign_jobtitle'];
        $interests = ($campaign_type['interests'] != 'false') ? implode($campaign_type['interests'], ',') : '';
        $keywords = (!empty($campaign_type['keywords'] != 'false')) ? implode(array_filter( $campaign_type['keywords'] ), ',') : '';
        $websites = (!empty($campaign_type['websites'] != 'false')) ? implode(array_filter( $campaign_type['websites'] ), ',') : '';

//        -------------------  campaign_images  ------------------------------
//
//        //        -------------------  campaign_master upload ------------------------------
//
        $affected1 = DB::update('UPDATE campaign_master SET campaign_name = "'.$campaign_name.'",
                                                           campaign_phone = "'.$campaign_phone.'",
                                                           objective = "'.$campaign_manage.'",
                                                           campaign_text = "'.$promotion.'",
                                                           fullname = "'.$fullname.'",
                                                           apt_suite = "'.$aptSuite.'",
                                                           city = "'.$city.'",
                                                           postal_code = "'.$postalCode.'",
                                                           street = "'.$street.'",
                                                           campaign_start_date = "'.$startDate.'",
                                                           campaign_end_date = "'.$finDate.'",
                                                           campaign_timeframe = "'.$checkTimeRadio.'",
                                                           campaign_price = "'.$checkPriceRadio.'",
                                                           campaign_logo = "'.$logo.'" WHERE id = "'.$id.'"');
//
//        //        -------------------  campaign_type upload ------------------------------

        $affected2 = DB::update("UPDATE campaign_type SET age_from = '$campaign_age_from',
                                                         age_to = '$campaign_age_to',
                                                         gender = '$gender',
                                                         languages = '$campaign_languages',
                                                         relationships = '$rel_status',
                                                         work = '$campaign_jobtitle',
                                                         interests = '$interests',
                                                         keywords = '$keywords',
                                                         placements = '$websites' WHERE campaign_id = '$id'");
//
//        // -------------------------------- location -----------------------------------
//
        $affected3 = true;

        $campaign_type = DB::table('campaign_type')->where('campaign_id', $id)->get();
        $loc_id = $campaign_type[0]->id;

        if ($locations != 'false') {
            DB::delete("DELETE FROM campaign_locations WHERE campaign_type_id = '$loc_id'");
            $count = 0;
            foreach ($locations[0] as $key) {
                $count++;
                $val1 = $locations[0][$count];
                $val2 = $locations[1][$count];
                $val3 = $locations[2][$count];
                $val4 = $locations[3][$count];
                if ($count != 1) {
                    $affected3 = DB::insert("INSERT INTO campaign_locations (campaign_type_id, location, target_city, postcode, mile_radius) VALUES ('$loc_id', '$val1','$val2','$val3', '$val4')");
                }
            }
        }

        DB::delete("DELETE FROM campaign_images WHERE campaign_id = '$id'");
        if ($gallery != 'false') {
            foreach ($gallery as $image) {
                DB::insert("INSERT INTO campaign_images (campaign_id, image) VALUES ('$id', '$image')");
            }
        }

        $result1 = ($affected1) ? true: false;
        $result2 = ($affected2) ? true: false;
        $result3 = ($affected3) ? true: false;

        $result = ($result1 || $result2 || $result3) ? true: false;

        return $result;
    }
}
