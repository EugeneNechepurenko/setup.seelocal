<?php

namespace App\Http\Controllers;

use App\Campaign_Interest;
use App\Campaign_Objective;
use App\Campaign_Plan;
use Illuminate\Http\Request;
use Auth;
use DB;
use Config;
//use App\Quotation;

use App\Http\Requests;

class PayController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }



    public function data_for_pay($request){
        
            $res_data = array(
                'transaction_id'    => 0,
                'status'            => '',
                'msg'               => ''
            );
        
            $fullName       = $request->fullName;
            $houseNumber    = $request->houseNumber;
            $city       = $request->city;
            $postcode       = $request->postcode;
            $street         = $request->street;
            $country        = $request->country;
            $cardType       = $request->cardType;
            $expiryDate     = $request->expiryDate;
            $cardNumber     = urlencode(trim($request->cardNumber));
            $securityCode   = $request->securityCode;
            $price          = 1; //$request->price;

        $expiryDate = str_replace('/', '', $expiryDate);


            $environment = Config::get('app.pay_mode');

            if( $fullName != false ){
                $names = explode(' ', $fullName);
                $firstName = $names[0];
                $lastName = isset($names[1]) ? $names[1] : '';
            }else{
                $firstName = $lastName = '';
            }
            
            // TMP hardcodes
            $paymentType = 'Sale';
            $currencyID = 'GBP';
            
            $nvpStr = "&PAYMENTACTION={$paymentType}&AMT={$price}&CREDITCARDTYPE={$cardType}&ACCT={$cardNumber}" .
                "&EXPDATE={$expiryDate}&CVV2={$securityCode}&FIRSTNAME={$firstName}&LASTNAME={$lastName}" .
                "&STREET={$houseNumber}&CITY={$city}&ZIP={$postcode}&COUNTRYCODE={$country}&CURRENCYCODE={$currencyID}&IPADDRESS=192.168.0.1";

            $httpParsedResponseAr = $this->PPHttpPost('DoDirectPayment', $nvpStr, $environment);

            if( !is_array($httpParsedResponseAr) ){
                    $res_data['msg'] = (string) $httpParsedResponseAr;
                    $res_data['status'] = 'Failure';
            }else{
                    if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
                            $res_data['transaction_id'] = $httpParsedResponseAr['TRANSACTIONID'];
                            $res_data['status'] = $httpParsedResponseAr['ACK'];
                    }else{
                            $res_data['transaction_id'] = 0;
                            $res_data['status'] = $httpParsedResponseAr['ACK'];
                            $res_data['msg'] = urldecode($httpParsedResponseAr['L_LONGMESSAGE0']);
                    }
            }

            return $res_data;
    }
    
    /**
    * Function to do request of payment to paypal gateway.
    * @param  $methodName_ 
    * @param  $nvpStr_     
    * @param  $environment     
    * @return array
    */
    public function PPHttpPost($methodName_, $nvpStr_, $environment) {
        // Set up your API credentials, PayPal end point, and API version.
        $API_UserName = Config::get('app.pay_'.$environment.'.API_UserName');
        $API_Password = Config::get('app.pay_'.$environment.'.API_Password');
        $API_Signature = Config::get('app.pay_'.$environment.'.API_Signature');                       
        
        $API_Endpoint = "https://api-3t.paypal.com/nvp";
        if ("test" === $environment) {
            $API_Endpoint = "https://api-3t.sandbox.paypal.com/nvp";
        }
        $version = urlencode('56.0');

        // Set the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        // Turn off the server and peer verification (TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        // Set the API operation, version, and API signature in the request.
        $nvpreq = "METHOD={$methodName_}&VERSION={$version}&PWD={$API_Password}&USER={$API_UserName}&SIGNATURE={$API_Signature}{$nvpStr_}";
        //return $nvpreq;
        // Set the request as a POST FIELD for curl.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

        // Get response from the server.
        $httpResponse = curl_exec($ch);
      
        if (!$httpResponse) {
            return "$methodName_ failed: " . curl_error($ch) . '(' . curl_errno($ch) . ')';
        }

        // Extract the response details.
        $httpResponseAr = explode("&", $httpResponse);

        $httpParsedResponseAr = array();
        foreach ($httpResponseAr as $i => $value) {
            $tmpAr = explode("=", $value);
            if (sizeof($tmpAr) > 1) {
                $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
            }
        }

        if ((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
            return "Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.";
        }

        return $httpParsedResponseAr;
    }

    /*
     * method for subscription
     * get data
    */
    public function get_pay_method_subscription($data) {

        $data->price = 3;
        $data->month = 3;
//        $data->month = $data->input_range_month;

        $environment = Config::get('app.pay_mode');
        $API_UserName = Config::get('app.pay_'.$environment.'.API_UserName');
        $API_Password = Config::get('app.pay_'.$environment.'.API_Password');
        $API_Signature = Config::get('app.pay_'.$environment.'.API_Signature');

        if ( $environment == 'test' ) {
            $url_api = 'https://api-3t.sandbox.paypal.com/nvp';
        } else {
            $url_api = 'https://api-3t.paypal.com/nvp';
        }

        // $API_UserName = 'djstreet11-facilitator_api1.gmail.com';
        // $API_Password = '249J535FRDR5376P';
        // $API_Signature = 'AjJBpjeV7yPc2bvBjiAbBT.8.-qVA4IJJGG57156YscGjMzg7AXWW2ZA';

        $expiryDate = str_replace('/', '', $data->expiryDate);
        $fullName = $data->fullName;
        $street = $data->street;
        $houseNumber = $data->houseNumber;
        $city = $data->city;
        $postcode = $data->postcode;
        $country = $data->country;
        $cardType = $data->cardType;
        $cardNumber = urlencode(trim($data->cardNumber));
        $securityCode = $data->securityCode;
        $price = $data->price / $data->month;
        $month = $data->month;
        $start_date = gmdate(date('Y-m-d',strtotime(str_replace('"', '', $data->start_date))).'\TH:i:s\Z');

        if ( $fullName != false ) {
            $names = explode(' ', $fullName);
            $firstName = $names[0];
            $lastName = isset($names[1]) ? $names[1] : '';
        } else {
            $firstName = $lastName = '';
        }

        $currencyID = 'GBP';
        $paymentType = 'Sale';

        $curl = curl_init();
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_URL, $url_api);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array(
            'USER' => $API_UserName,
            'PWD' => $API_Password,
            'SIGNATURE' => $API_Signature,  
            'METHOD' => 'CreateRecurringPaymentsProfile',
            'VERSION' => '108',
            'AMT' => $price,
            'PAYMENTACTION' => $paymentType,
            'CREDITCARDTYPE' => $cardType,
            'ACCT' => $cardNumber,
            'EXPDATE' => $expiryDate,
            'CVV2' => $securityCode,
            'FIRSTNAME' => $firstName,
            'LASTNAME' => $lastName,
            'STREET' => $houseNumber,
            'CITY' => $city,
            'ZIP' => $postcode,
            'COUNTRYCODE' => $country,
            'CURRENCYCODE' => $currencyID,
            'IPADDRESS' => '192.168.0.1',
            'BILLINGPERIOD' => 'Month',
            'BILLINGFREQUENCY' => $month,
            'INITAMT' => $price,
            'PROFILESTARTDATE' => $start_date
        )));

        $response = curl_exec($curl);

        echo '<pre>';
        $xxxxx = http_build_query(array(
            'USER' => $API_UserName,
            'PWD' => $API_Password,
            'SIGNATURE' => $API_Signature,
            'METHOD' => 'CreateRecurringPaymentsProfile',
            'VERSION' => '108',
            'AMT' => $price,
            'PAYMENTACTION' => $paymentType,
            'CREDITCARDTYPE' => $cardType,
            'ACCT' => $cardNumber,
            'EXPDATE' => $expiryDate,
            'CVV2' => $securityCode,
            'FIRSTNAME' => $firstName,
            'LASTNAME' => $lastName,
            'STREET' => $houseNumber,
            'CITY' => $city,
            'ZIP' => $postcode,
            'COUNTRYCODE' => $country,
            'CURRENCYCODE' => $currencyID,
            'IPADDRESS' => '192.168.0.1',
            'BILLINGPERIOD' => 'Month',
            'BILLINGFREQUENCY' => $month,
            'INITAMT' => $price,
            'PROFILESTARTDATE' => $start_date
        ));
        print_r($xxxxx);
        echo '</pre>';

        $nvp = array();

        if (preg_match_all('/(?<name>[^\=]+)\=(?<value>[^&]+)&?/', $response, $matches)) {
            foreach ($matches['name'] as $offset => $name) {
                $nvp[$name] = urldecode($matches['value'][$offset]);
            }
        }

        var_dump('<pre>');
        print_r($nvp);
        var_dump('</pre>');
        die;
    }

}
