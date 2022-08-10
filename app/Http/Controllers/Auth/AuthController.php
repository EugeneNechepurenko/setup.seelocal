<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Campaign;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Hash;
use Auth;
use Closure;
use DB;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
	protected $redirectTo = '/step/1';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
	public function __construct()
	{
		//$this->middleware($this->guestMiddleware(), ['except' => 'logout']);
	}

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
	protected function validator(array $data)
	{
		return Validator::make($data, [
		'first_name' => 'required|max:250',
		// 'last_name' => 'required|max:250',
		'company_name' => 'required|max:255',
		'phone_number' => 'required|max:50',
		'email' => 'required|email|max:255|unique:user_management',
		'password' => 'required|min:6|confirmed',
		]);
	}

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
	protected function create(array $data)
	{
        $key = 'abcd5435423aderst';

        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $data['password'], MCRYPT_MODE_CBC, md5(md5($key))));


        return User::create([
		'first_name' => $data['first_name'],
		'last_name' => $data['first_name'],
		'company_name' => $data['company_name'],
		'phone_number' => $data['phone_number'],
		'email' => $data['email'],
		'password' => $encrypted,
		]);
	}
	public function getAuthIdentifierName(){return 'id';}
	public function getAuthIdentifier(){$name = $this->getAuthIdentifierName();  return $this->{$name};}
	public function getAuthPassword() {return $this->getPassword();}


	public function login_remote_data($auth){
        $auth = base64_decode($this->decrypts($auth));
        $data = explode(':',$auth);
        if(!is_array($data)) return print_r(' fail ', true);
        if(sizeof($data) != 2) return print_r(' fail ', true);

        $login = base64_decode($data[0]);
        $pass = base64_decode($data[1]);
        return response()->json(array('login'=>$login,'pass'=>$pass));
    }


	public function login_remote($auth){
	    $key = $auth;
		$auth = base64_decode($this->decrypts($auth));
		$data = explode(':',$auth);
		if(!is_array($data)) return print_r(' fail ', true);
		if(sizeof($data) != 2) return print_r(' fail ', true);

		$login = base64_decode($data[0]);
		$pass = base64_decode($data[1]);

		$key = 'abcd5435423aderst';
		$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $pass, MCRYPT_MODE_CBC, md5(md5($key))));
		$user = User::where('email', $login)->where('password', $encrypted)->first();
		if($user){
			$auth = Auth::loginUsingId($user->id,true);
			if($auth == true) {
				$user_info = $this->get_user_step_info(Auth::user()->id);
//				print_r( array('user' => Auth::user()->id, 'info' => $user_info, 'auth_data'=>$auth->remember_token) );
				$id = Auth::user()->id;
                $remember_token = $auth->remember_token;
				$res = DB::connection('user_steps')->table('history_orders')->where('user_id', $id)->get();
				if(!empty($res)){
					DB::connection('user_steps')->table('user_info')->where('user_id', $res[0]->user_id)->update(['user_info'=>$res[0]->user_info]);
//					redirect('/step/5');
//					return redirect('/login?reorder=1&key='.$key);
					return view('layouts.app');
				}else{
					echo 'no last order';
				}
			} else if($auth == false) {
				return print_r('auth fail ', true);
			} else {
				return print_r('auth error ', true);
			}
		}else{
			return print_r('no user', true);
		}


//		return redirect('/login');
	}



	function encrypts ($str)
	{

		// define base info
		$key='megakey'; //key
		$dic = '1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; //symbols from which will be creating our list of characters
		$dict[0]=$dic; // set first string line of list

		// START creating list of characters

		$t = ''; //temp variable

		//strlen($dic) = its a length of $dic, so array will have same length as length of $dic
		//we already set zero in array so start loop from 1st, that`s why "length - 1"
		for ($d=1; $d<=strlen($dic)-1; $d++) // starting loop of creating list
		{


			for ($x=0; $x<=strlen($dic); $x++) // start loop of creating array of element from which will have line in list
			{
				$dict_l=strlen($dic); // get length of our symbols

				//for 1st element in line, get last element to first place
				if(isset($dict[$d - 1][$dict_l])) { //check for availability symbol in the previous array element, for example $dict[0][12] = A
					$tmp[0] = $dict[$d - 1][$dict_l]; // adding to temp. variable symbol from $dict
				}


				//for other elements in line
				if($x>0)
				{
					// set all other element without 1st and last element
					if(isset($dict[$d-1][$x])) { //check for availability symbol in the previous array element, for example $dict[0][12] = A
						$tmp[$x] = $dict[$d - 1][$x]; // adding to temp. variable symbol from $dict
					}
					//send first element from prev. array element to last position in new array element
					$tmp[$dict_l]=$dict[$d-1][0]; // adding to temp. variable symbol from $dict
				}
			}

			for ($i=0; $i<=strlen($dic); $i++) // start loop for creating string line from array
			{
				if(isset($tmp[$i])) { // check the element for not empty value, so if element empty will skip
					$t .= $tmp[$i]; // adding character from not empty elements from array to string line
				}
			}
			// after loop will have "234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1" in $t

			$dict[$d]=$t; // add $t to new element to array (list)
			$t=""; // remove created string for creating next string
		}

		// $dict have list of dictionaries http://joxi.ru/zAN4w5YidLQBm9
		// $dict[0] have our string

		// creating list of symbols from key with length of our string
		$j=0; // set temp. variable
		$k1 = array();// array for list of symbols
		for ($i=0; $i<=strlen($str)-1; $i++) //start loop of creating list of symbols from length of our string
		{
			$k1[$i] = $key[$j]; // get symbol from key, for example 1st symbol from key is "m", so
			$j=$j+1; // add 1 for get next symbol
			if($j==strlen($key)) // if it is last symbol in key, strlen($key) will give length of key, for example, $j = 7 and length (of string) of key is 7, so we set $j = 0
			{
				$j=0; // set 0 for start getting symbols from key from start (from 1st symbol)
			}
		}

		$k0=$str; // set $k1 = our string
		$crypt_word = ''; // define string variable for encrypt word
		for ($i=0; $i<=count($k1)-1; $i++) // start encrypting loop
		{
			// 1) our crypt word - ZEdWemRESkFkR1Z6ZEM1MFpYTno6TVRFeE1URXg=
			// 2) our key - mega_keymega_keymega_key..
			// 3) our zero element in list of dictionaries - 1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz
			// 4) 50th element in list of dictionaries - mnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkl
			$s1=$k0[$i]; // $i=0, so get zero element from 1), it is Z
			$s2=$k1[$i]; // $i=0, so get zero element from 2), it is m
			$p_s1 = strpos($dict[0], $s1); // get position of symbol $s1 from 3), it is 37
			$p_s2 = strpos($dict[0], $s2); // get position of symbol $s2 from 3), it is 50

			$crypt_word .= $dict[$p_s2][$p_s1];// get 37th character from 50th element in our list of dictionaries, it is L AND add $crypt_word
		}
		return $crypt_word; // return done string veriable with encrypted word
	}
	function decrypts ($crypt)
	{
		$key='megakey';
		$dic = '1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$dict[0]=$dic;
		$t = '';

		//loop the same as in crypt function
		for ($d=1; $d<=strlen($dic)-1; $d++) //creating list of dictionaries
		{
			for ($x=0; $x<=strlen($dic); $x++)
			{
				$dict_l=strlen($dic);
				if(isset($dict[$d - 1][$dict_l])) {
					$tmp[0] = $dict[$d - 1][$dict_l];
				}
				if($x>0)
				{
					if(isset($dict[$d-1][$x])) {
						$tmp[$x] = $dict[$d - 1][$x];
					}
					$tmp[$dict_l]=$dict[$d-1][0];
				}
			}
			for ($i=0; $i<=strlen($dic); $i++)
			{
				if(isset($tmp[$i])) {
					$t .= $tmp[$i];
				}
			}
			$dict[$d]=$t;
			$t="";
		}
		// $dict have list of dictionaries

		//loop the same as in crypt function
		$j=0;
		$k1 = array();
		for ($i=0; $i<=strlen($crypt)-1; $i++)
		{
			$k1[$i] = $key[$j];
			$j=$j+1;
			if($j==strlen($key))
			{
				$j=0;
			}
		}


		$k0=$crypt;
		$decrypt_word = '';
		for ($i=0; $i<=count($k1)-1; $i++)
		{
			// 1) our string for decrypting LuJ9OQP39QrU8yLjFq9eK4TE6XS4F@0rOuyG8DGu
			// 2) our key - mega_keymega_keymega_key..
			// 3) our zero element in list of dictionaries - 1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz
			// 4) 37th element in list of dictionaries - Zabcdefghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXY
			$s1=$k0[$i]; // $i=0, so get zero element from 1), it is L
			$s2=$k1[$i]; // $i=0, so get zero element from 2), it is m
			$p_s2 = strpos($dict[0], $s2); // get position of symbol $s2 from 3), it is 50
			$num_s = strpos($dict[$p_s2], $s1); // get position of symbol $s1 from element, number which we get in $p_s2, it is 37
			$decrypt_word .=  $dict[0][$num_s]; // get symbol from zero element from list, number which is 37, which we get in $num_s, it is Z
		}
		return $decrypt_word; //return decrypted word
	}




	/*
	 * select user info for steps from DB use connection 'user_steps'
	 * get $user_id
	 * return array
	*/
	public function get_user_last_order($user_id) {
		$user_steps = DB::connection('user_steps')->table('user_info')->where(['user_id' => $user_id])->first();
		if ( $user_steps ) {
			$user_info = json_decode($user_steps->user_info);
			if ( $user_info ) {
				return $user_info;
			} else {
				return 'no';
			}
		} else {
			return 'no';
		}
	}






    public function update_user(Request $request){

		if($request->field == 'f_name'){
			User::where('id', $request->id)->update(['first_name' => $request->data]);
			return response('ok');
		}
		// if($request->field == 'l_name'){
		// 	User::where('id', $request->id)->update(['last_name' => $request->data]);
		// 	return response('ok');
		// }
		if($request->field == 'phone'){
			User::where('id', $request->id)->update(['phone_number' => $request->data]);
			return response('ok');
		}
		if($request->field == 'email'){
			$tmp = User::where('email', $request->data)->count();
			if($tmp == 0){
				User::where('id', $request->id)->update(['email' => $request->data]);
				return response('ok');
			}
			if($tmp > 0){
				return response('exist');
			}
		}
		if($request->field == 'pass'){

            $key = 'abcd5435423aderst';

            $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $request->data, MCRYPT_MODE_CBC, md5(md5($key))));


            User::where('id', $request->id)->update(['password' => $encrypted]);
			return response('ok');
		}


		if($request->field == 'address'){
			Campaign::where('id', $request->last_id_campaing)->update(['street' 		=> $request->user_street]);
			Campaign::where('id', $request->last_id_campaing)->update(['state_code' 	=> $request->user_region]);
			Campaign::where('id', $request->last_id_campaing)->update(['city' 		=> $request->user_city]);
			Campaign::where('id', $request->last_id_campaing)->update(['postal_code'  => $request->user_zip]);
			return response('ok');
		}

       return response('end');
    }


    public function user(){
		$user_data = Auth::user();
//        Campaign::where('created_by',$user_data->id)
//            ->orderBy('id', 'desc')
//            ->first();

		return array(
		'address'=>DB::table('campaign_master')->where(['created_by' => $user_data->id])->orderBy('id', 'desc')->first(),
		'user_data'=>Auth::user()
        );
		//return array('address'=>Campaign::where('created_by',$user_data->id)->orderBy('id', 'desc')->first(),'user_data'=>Auth::user());
    }

    public function user_invoices(Request $request){
        $skip = (isset($request->skip))? $request->skip : '0';
		if($skip == '0'){
			return DB::table('campaign_master')->where(['created_by' => $request->id])->orderBy('id', 'desc')->take(3)->get();
		}else{
			return DB::table('campaign_master')->where(['created_by' => $request->id])->orderBy('id', 'desc')->skip((int)$request->skip)->take(3)->get();
		}
    }





    public function check(){
		return Auth::check() ? Auth::user() : 0;
	}

    public function test(Request $request){
		//        print_r($request);
		return response( 'tets' );
	}

	public function login(Request $request){
		$credentials = $this->getCredentials($request);
		//         if (! Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
		//             return response('These credentials do not match our records.', 403);
		//         }
		//$res = Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'));

		//$data = json_decode($credentials);
		// $user = User::find($credentials['password']);
		// Auth::loginUsingId($res->id,true)
		//var_dump(Auth::attempt(array('email' => $credentials['email'], 'password' => $credentials['password'])));


		//$auth = (bool) Auth::attempt(array('email' => $credentials['email'], 'password' => $credentials['password']),true);


        $key = 'abcd5435423aderst';
        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $credentials['password'], MCRYPT_MODE_CBC, md5(md5($key))));
//		return response($encrypted);
        $user = User::where('email', $credentials['email'])
            ->where('password', $encrypted)
            ->first();

		if($user){
			$auth = Auth::loginUsingId($user->id,true);
			if($auth == true) {
				$user_info = $this->get_user_step_info(Auth::user()->id);
				return response( array('user' => Auth::user(), 'info' => $user_info) );
			} else if($auth == false) {
				return response('auth false');
			} else {
				return response('auth error');
			}
		}else{
			return response('no user');
		}
//



		/*
	    if (Auth::attempt(array('email' => $credentials['email'], 'password' => $credentials['password']),true))
	    {
	    }*/


//		return response(  );
	}
    public function logout()
    {
        Auth::guard($this->getGuard())->logout();
        return response(null, 200);
    }




    public function register(Request $request)
	{
		/*  $validator = $this->validator($request->all()); if ($validator->fails()) { $this->throwValidationException( $request, $validator ); }  */
		$data = json_decode($request->getContent());

//        $key = 'abcd5435423aderst';
//        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), (string)$data->password, MCRYPT_MODE_CBC, md5(md5($key))));

        $res = User::create([
		'first_name' => $data->first_name,
		'last_name' => $data->first_name,
		'company_name' => $data->company_name,
		'phone_number' => $data->phone_number,
		'email' => $data->email,
		'password' => $data->password,
		]);
//		var_dump($encrypted);
//		exit;
		$user = User::find($res);
		$us = Auth::loginUsingId($res->id,true);

		$this->send_registration_mail($data->first_name,$data->email);
		return response( Auth::user());
	}


    public function send_registration_mail($name,$email){

        $in_browser = base64_encode(json_encode(
            array(
                'name'=>$name,
                'mail'=>$email,
            ))
    );
$html = "
<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">
<html>
  <head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
    <title>seelocal | Thank you!</title> 

<link href='https://fonts.googleapis.com/css?family=Lato:400,600,700,300' rel='stylesheet' type='text/css'>
    <meta name=\"viewport\" content=\"width=device-width,minimum-scale=1,initial-scale=1\">    
  </head>
  <body style=\"margin: 0\">  
  <style> 
@media only screen and (min-width: 640px) {
  td>img[class=\"logo\"] {
    width: 350px!important;
  }
}

@media only screen and (max-width: 640px) {
  table {
    font-size: 90%!important;
  }
  td[class=\"title\"] {
    font-size: 2.5em!important;
  }
}
  </style>   

    <table border='0' cellpadding='0' cellspacing='0' style='margin:0; padding:0; font-size: 100%; color: white; font-family: Lato, Arial; font-weight: 300 ' width='100%'>
         <thead bgcolor='#4DC01D'>
            <tr bgcolor='#4DC01D'>
              <td align='right' style=' padding: 1.3%'> 
                <a href='https://setup-campaign.seelocal.co.uk/mail/registration?{$in_browser}' target='_blank' style=\"font-size: 1.1em; font-family: 'Lato', Arial; font-weight: 300; letter-spacing: 1px; text-decoration: none; color: white; display: block;\" >View this email in your browser</a>
              </td>
           </tr>
           <tr bgcolor='#4DC01D'>
              <td style=' padding: 0.5em 4.5%'> 
                   <img class='logo' src='https://setup-campaign.seelocal.co.uk/images/logo-tr.png' alt='logo-company' border='0' width='270' style='display:block'> 
              </td>
           </tr>
           <tr bgcolor='#4DC01D'>
              <td align='center' class='title' style=\"font-size: 3.25em; font-family: 'Lato', Arial; font-weight: 300; padding-top: 5.5%; padding-right: 7%; padding-left: 7%; line-height: 1.3em\">{$name}, </td>
           </tr>
           <tr bgcolor='#4DC01D'>
              <td align='center' class='title' style=\"font-size: 3.25em; line-height: 1.1em; font-family: 'Lato', Arial; font-weight: 300; padding-left: 7%; padding-right: 7%\"> Welcome to Seelocal</td>
           </tr>
           <tr bgcolor='#4DC01D'>
              <td align='center' style='font-size: 1.875em; font-family: Lato, Arial; font-weight: 300; line-height: 1.2em;
    padding: 36px 14% 57px 14%;'>Thank you for registering an account with us, please confirm your email
address to create your first campaign</td>
           </tr>
         </thead> 
         <tbody>
            <tr>
               <td bgcolor='#ffffff' style=\"color: #252525; font-size: 1.875em; font-family: 'Lato', Arial; font-weight: 300; padding-top: 2em; padding-right: 11.5%; padding-left: 11.5%; margin: 0\">Confirm your email address</td>
            </tr>
            <tr>
              <td bgcolor='#ffffff' style=\"font-size: 1.25em; color: #252525; font-family: 'Lato', Arial; font-weight: 300; padding-top: 0.6em; padding-right: 11.5%; padding-left: 11.5%; padding-bottom: 0.9em;\">                  
                  To complete your account setup with Seelocal, please click the button below to confirm that <a target='_blank' style='text-decoration: none; color: #4dc01d;' href='#'>{$email}</a> is the email that you would like to use
               </td>
            </tr>
            <tr>
              <td bgcolor='#ffffff' style='padding: 3em 11.5% 1px 11.5%;'>  
                   <table border='0' cellpadding='0' cellspacing='0' style='width: 218px; '  >
                    <!-- style='width: 218px; background: #02516C; border-radius: 30px; -webkit-border-radius: 30px;' -->
                     <tr>
                       <td style='height: 50px; background: #02516C; text-decoration: none; border-radius: 30px; -webkit-border-radius: 30px; text-align: center;'>
                        <!-- text-decoration: none; background: blue; color: white;  padding-top: 0.9em; padding-bottom: 0.9em; text-align: center; width: 100% -->
                         <a target='_blank'  style=\"text-decoration: none; font-family: 'Lato', Arial; font-size: 1.25em; font-weight: 300; color: white;\" href='https://setup-campaign.seelocal.co.uk'>Confirm</a>  
                       </td>
                     </tr>
                   </table>
              </td>
            </tr>
             <tr>
               <td bgcolor='#ffffff' style=\"color: #252525; font-size: 1.875em; font-family: 'Lato', Arial; font-weight: 300; padding-top: 2.1em; padding-right: 11.5%; padding-left: 11.5%; margin: 0\">Make changes to your account</td>
            </tr>
             <tr>
              <td bgcolor='#ffffff' style=\"font-size: 1.25em; color: #252525; font-family: 'Lato', Arial; font-weight: 300; padding-top: 0.8em; padding-right: 11.5%; padding-left: 11.5%; padding-bottom: 3.5em;\">                  
                 To use another email, or to change any of your account details please <a target='_blank' style='text-decoration: none; color: #4dc01d;' href='https://setup-campaign.seelocal.co.uk'>click here</a> 
               </td>
            </tr>
            <tr bgcolor='#02516C'>
              <td align='center' bgcolor='#02516C' style=\"font-size: 1.875em; font-family: 'Lato', Arial; font-weight: 300; padding: 1.5em 7% 0.5em 7%; margin: 0; color: white\">Thanks, from the Seelocal team 
              </td>
            </tr>
            <tr bgcolor='#02516C'>
              <td align='center' bgcolor='#02516C' style=\"color: white; font-family: 'Lato', Arial; font-weight: 300; font-size: 1.25em; line-height: 1.1em; padding: 5px 7% 45px 7%\">
                If you have any questions regarding your campaign get in touch with a member of our team on <span style='white-space: nowrap'>01295 817 638</span>
              </td>
            </tr>
            <tr bgcolor='#424041'>
              <td  align='center' style=\"color: white; font-family: 'Lato', Arial;font-weight: 300; font-size: 1em; padding: 1.25em 7%\">
                 Copyright &copy; 2016, SeeLocal Ltd, All rights reserved
              </td>
            </tr>
         </tbody>
    </table> 
  </body>
</html>
";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Seelocal <admin@setup-campaign.seelocal.co.uk>' . "\r\n";
	$headers .= 'X-Mailer: PHP/' . phpversion();
	if( mail($email, 'Registration', $html, $headers) ){
        $f = fopen('/var/www/html/public/log_debug_eugene.txt','a+');
        fwrite($f," ".date('Y-d-m _ H:i:s')." - send registration_email = ok | name = '{$name}','{$email}' \n");
        fclose($f);
    }else{
        $f = fopen('/var/www/html/public/log_debug_eugene.txt','a+');
        fwrite($f," ".date('Y-d-m _ H:i:s')." - send registration_email = fail | name = '{$name}','{$email}' \n");
        fclose($f);
    }

	if( mail('admin@seelocal.co.uk', 'Registration', $html, $headers) ){
        $f = fopen('/var/www/html/public/log_debug_eugene.txt','a+');
        fwrite($f," ".date('Y-d-m _ H:i:s')." - send registration_email admin = ok | name = '{$name}','admin@seelocal.co.uk' \n");
        fclose($f);
    }else{
        $f = fopen('/var/www/html/public/log_debug_eugene.txt','a+');
        fwrite($f," ".date('Y-d-m _ H:i:s')." - send registration_email admin = fail | name = '{$name}','admin@seelocal.co.uk' \n");
        fclose($f);
    }

    }


    public function contactus(Request $request){

        $fields = "name {$request->name}<br>";
        $fields .= ($request->client_id != '')? "client_id {$request->client_id}<br>" : '';
        $fields .= "email {$request->email}<br>";
        $fields .= "message {$request->message}<br>";
        $fields .= "phone {$request->phone}<br>";
        $fields .= ($request->text != '')? "text {$request->text}<br>" : '';
        $html = "
                    <!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">
                    <html>
                      <head>
                        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
                        <title>seelocal | New password</title>
                        <link href='https://fonts.googleapis.com/css?family=Lato:400,600,700,300' rel='stylesheet' type='text/css'>
                        <meta name=\"viewport\" content=\"width=device-width,minimum-scale=1,initial-scale=1\">
                      </head>
                      <body>
                     {$fields}
                      </body>
                    </html>
                    ";
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: Seelocal <admin@setup-campaign.seelocal.co.uk>' . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();
        if( mail('admin@seelocal.co.uk', 'Contact us', $html, $headers) ){}
    }

	/*
	 * select user info for steps from DB use connection 'user_steps'
	 * get $user_id
	 * return array
	*/
	public function get_user_step_info($user_id) {
		$user_steps = DB::connection('user_steps')->table('user_info')->where(['user_id' => $user_id])->first();
		if ( $user_steps ) {
			$user_info = json_decode($user_steps->user_info);
			if ( $user_info ) {
				return $user_info;
			} else {
				return 'no';
			}
		} else {
			return 'no';
		}
	}


	public function forgot_pass(Request $request)
    {

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $key = 'abcd5435423aderst';
            $pass = uniqid();
            $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $pass, MCRYPT_MODE_CBC, md5(md5($key))));
            User::where('email', $request->email)->update(['password' => $encrypted]);

            $html = "
                    <!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">
                    <html>
                      <head>
                        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
                        <title>seelocal | New password</title>
                        <link href='https://fonts.googleapis.com/css?family=Lato:400,600,700,300' rel='stylesheet' type='text/css'>
                        <meta name=\"viewport\" content=\"width=device-width,minimum-scale=1,initial-scale=1\">
                      </head>
                      <body>
                      Your new password is {$pass}
                      </body>
                    </html>
                    ";
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: Seelocal <admin@setup-campaign.seelocal.co.uk>' . "\r\n";
            $headers .= 'X-Mailer: PHP/' . phpversion();
            if (mail($request->email, 'New password', $html, $headers)) {
//            if (mail('djstreet11@gmail.com', 'New password', $html, $headers)) {
            }
//            if (mail('djstreet11@gmail.com', 'New password', $html, $headers)) {
//            }

            return response('ok');
        } else {
            return response('false');
        }
    }


//
////djstreet11@outlook.com,
////
////$to = 'alex.bury@seelocal.co.uk';
////       $to = 'alex.bury@seelocal.co.uk, djstreet11@gmail.com, djstreet11@yahoo.com, djstreetstyle@mail.ru';
//       $to = 'alex.bury@seelocal.co.uk, djstreet11@gmail.com, djstreet11@outlook.com';
//       $to2 = 'alex.bury@seelocal.co.uk';
//
//
//
//
//
////        $html = "
////                    <!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">
////                    <html>
////                      <head>
////                        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
////                        <title>seelocal | Test mail</title>
////                        <link href='https://fonts.googleapis.com/css?family=Lato:400,600,700,300' rel='stylesheet' type='text/css'>
////                        <meta name=\"viewport\" content=\"width=device-width,minimum-scale=1,initial-scale=1\">
////                      </head>
////                      <body>
////                      TEST
////                      </body>
////                    </html>
////                    ";
////        $headers = 'MIME-Version: 1.0' . "\r\n";
////        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
////        $headers .= 'From: Seelocal <admin@setup-campaign.seelocal.co.uk>' . "\r\n";
////        $headers .= 'X-Mailer: PHP/' . phpversion();
////        if (mail($to, 'Test mail', $html, $headers)) {        }
//
//
//
//
//
////new password
//        $html = "
//                    <!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">
//                    <html>
//                      <head>
//                        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
//                        <title>seelocal | New password</title>
//                        <link href='https://fonts.googleapis.com/css?family=Lato:400,600,700,300' rel='stylesheet' type='text/css'>
//                        <meta name=\"viewport\" content=\"width=device-width,minimum-scale=1,initial-scale=1\">
//                      </head>
//                      <body>
//                      Your new password is 57bd915c31325
//                      </body>
//                    </html>
//                    ";
//        $headers = 'MIME-Version: 1.0' . "\r\n";
//        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//        $headers .= 'From: Seelocal <admin@setup-campaign.seelocal.co.uk>' . "\r\n";
//        $headers .= 'X-Mailer: PHP/' . phpversion();
//        if (mail($to, 'New password', $html, $headers)) {}
//
//
//// Registration
////***************************************************************************************************
//$html = "
//<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">
//<html>
//  <head>
//    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
//    <title>seelocal | Thank you!</title>
//
//<link href='https://fonts.googleapis.com/css?family=Lato:400,600,700,300' rel='stylesheet' type='text/css'>
//    <meta name=\"viewport\" content=\"width=device-width,minimum-scale=1,initial-scale=1\">
//  </head>
//  <body style=\"margin: 0\">
//  <style>
//@media only screen and (min-width: 640px) {
//  td>img[class=\"logo\"] {
//    width: 350px!important;
//  }
//}
//
//@media only screen and (max-width: 640px) {
//  table {
//    font-size: 90%!important;
//  }
//  td[class=\"title\"] {
//    font-size: 2.5em!important;
//  }
//}
//  </style>
//
//    <table border='0' cellpadding='0' cellspacing='0' style='margin:0; padding:0; font-size: 100%; color: white; font-family: Lato, Arial; font-weight: 300 ' width='100%'>
//         <thead bgcolor='#4DC01D'>
//            <tr bgcolor='#4DC01D'>
//              <td align='right' style=' padding: 1.3%'>
//                <a href='#' target='_blank' style=\"font-size: 1.1em; font-family: 'Lato', Arial; font-weight: 300; letter-spacing: 1px; text-decoration: none; color: white; display: block;\" >View this email in your browser</a>
//              </td>
//           </tr>
//           <tr bgcolor='#4DC01D'>
//              <td style=' padding: 0.5em 4.5%'>
//                   <img class='logo' src='https://setup-campaign.seelocal.co.uk/images/logo-tr.png' alt='logo-company' border='0' width='270' style='display:block'>
//              </td>
//           </tr>
//           <tr bgcolor='#4DC01D'>
//              <td align='center' class='title' style=\"font-size: 3.25em; font-family: 'Lato', Arial; font-weight: 300; padding-top: 5.5%; padding-right: 7%; padding-left: 7%; line-height: 1.3em\">Eugene, </td>
//           </tr>
//           <tr bgcolor='#4DC01D'>
//              <td align='center' class='title' style=\"font-size: 3.25em; line-height: 1.1em; font-family: 'Lato', Arial; font-weight: 300; padding-left: 7%; padding-right: 7%\"> Welcome to Seelocal</td>
//           </tr>
//           <tr bgcolor='#4DC01D'>
//              <td align='center' style='font-size: 1.875em; font-family: Lato, Arial; font-weight: 300; line-height: 1.2em;
//    padding: 36px 14% 57px 14%;'>Thank you for registering an account with us, please confirm your email
//address to create your first campaign</td>
//           </tr>
//         </thead>
//         <tbody>
//            <tr>
//               <td bgcolor='#ffffff' style=\"color: #252525; font-size: 1.875em; font-family: 'Lato', Arial; font-weight: 300; padding-top: 2em; padding-right: 11.5%; padding-left: 11.5%; margin: 0\">Confirm your email address</td>
//            </tr>
//            <tr>
//              <td bgcolor='#ffffff' style=\"font-size: 1.25em; color: #252525; font-family: 'Lato', Arial; font-weight: 300; padding-top: 0.6em; padding-right: 11.5%; padding-left: 11.5%; padding-bottom: 0.9em;\">
//                  To complete your account setup with Seelocal, please click the button below to confirm that <a target='_blank' style='text-decoration: none; color: #4dc01d;' href='#'>{$to}</a> is the email that you would like to use
//               </td>
//            </tr>
//            <tr>
//              <td bgcolor='#ffffff' style='padding: 3em 11.5% 1px 11.5%;'>
//                   <table border='0' cellpadding='0' cellspacing='0' style='width: 218px; '  >
//                    <!-- style='width: 218px; background: #02516C; border-radius: 30px; -webkit-border-radius: 30px;' -->
//                     <tr>
//                       <td style='height: 50px; background: #02516C; text-decoration: none; border-radius: 30px; -webkit-border-radius: 30px; text-align: center;'>
//                        <!-- text-decoration: none; background: blue; color: white;  padding-top: 0.9em; padding-bottom: 0.9em; text-align: center; width: 100% -->
//                         <a target='_blank'  style=\"text-decoration: none; font-family: 'Lato', Arial; font-size: 1.25em; font-weight: 300; color: white;\" href='https://setup-campaign.seelocal.co.uk'>Confirm</a>
//                       </td>
//                     </tr>
//                   </table>
//              </td>
//            </tr>
//             <tr>
//               <td bgcolor='#ffffff' style=\"color: #252525; font-size: 1.875em; font-family: 'Lato', Arial; font-weight: 300; padding-top: 2.1em; padding-right: 11.5%; padding-left: 11.5%; margin: 0\">Make changes to your account</td>
//            </tr>
//             <tr>
//              <td bgcolor='#ffffff' style=\"font-size: 1.25em; color: #252525; font-family: 'Lato', Arial; font-weight: 300; padding-top: 0.8em; padding-right: 11.5%; padding-left: 11.5%; padding-bottom: 3.5em;\">
//                 To use another email, or to change any of your account details please <a target='_blank' style='text-decoration: none; color: #4dc01d;' href='https://setup-campaign.seelocal.co.uk'>click here</a>
//               </td>
//            </tr>
//            <tr bgcolor='#02516C'>
//              <td align='center' bgcolor='#02516C' style=\"font-size: 1.875em; font-family: 'Lato', Arial; font-weight: 300; padding: 1.5em 7% 0.5em 7%; margin: 0; color: white\">Thanks, from the Seelocal team
//              </td>
//            </tr>
//            <tr bgcolor='#02516C'>
//              <td align='center' bgcolor='#02516C' style=\"color: white; font-family: 'Lato', Arial; font-weight: 300; font-size: 1.25em; line-height: 1.1em; padding: 5px 7% 45px 7%\">
//                If you have any questions regarding your campaign get in touch with a member of our team on <span style='white-space: nowrap'>01295 817 638</span>
//              </td>
//            </tr>
//            <tr bgcolor='#424041'>
//              <td  align='center' style=\"color: white; font-family: 'Lato', Arial;font-weight: 300; font-size: 1em; padding: 1.25em 7%\">
//                 Copyright &copy; 2016, SeeLocal Ltd, All rights reserved
//              </td>
//            </tr>
//         </tbody>
//    </table>
//  </body>
//</html>
//";
//        $headers = 'MIME-Version: 1.0' . "\r\n";
//        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//        $headers .= 'From: Seelocal <admin@setup-campaign.seelocal.co.uk>' . "\r\n";
//        $headers .= 'X-Mailer: PHP/' . phpversion();
//        if (mail($to, 'Registration', $html, $headers)) {}
////        if (mail($to2, 'Registration', $html, $headers)) {}
//
//
////Abandoned cart
////***************************************************************************************************
// $email_html = '
//<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
//<html>
//  <head>
//    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
//    <title>seelocal | Abandoned cart</title>
//
//<link href=\'https://fonts.googleapis.com/css?family=Lato:400,600,700,300\' rel=\'stylesheet\' type=\'text/css\'>
//    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
//  </head>
//  <body style="margin: 0">
//  <style>
//@media only screen and (min-width: 640px) {
//  td>img[class="logo"] {
//    width: 350px!important;
//  }
//}
//
//@media only screen and (max-width: 640px) {
//  table {
//    font-size: 90%!important;
//  }
//  td[class="title"] {
//    font-size: 2.5em!important;
//  }
//}
//
//@media only screen and (max-width: 1900px) {
//  td[class="pl11"] {
//    padding-left: 11.5%!important;
//    padding-right: 11.5%!important;
//  }
//}
//
//  </style>
//    <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; font-size: 100%; color: white; font-family: Lato, Arial; font-weight: 300 " width="100%">
//         <thead bgcolor="#4DC01D">
//            <tr bgcolor="#4DC01D">
//              <td align="right" style=" padding: 1.3%">
//                <a href="#" target="_blank" style="font-size: 1.1em; font-family: \'Lato\', Arial; font-weight: 300; letter-spacing: 1px; text-decoration: none; color: white; display: block;" >View this email in your browser</a>
//              </td>
//           </tr>
//           <tr bgcolor="#4DC01D">
//              <td style=" padding: 0.5em 4.5%">
//                   <img class="logo" src="https://setup-campaign.seelocal.co.uk/images/logo-tr.png" alt="logo-company" border="0" width="270" style="display:block">
//              </td>
//           </tr>
//           <tr bgcolor="#4DC01D">
//              <td align="center" class="title" style="font-size: 3.25em; font-family: \'Lato\', Arial; font-weight: 300; padding-top: 5.5%; padding-right: 7%; padding-left: 7%; line-height: 1.3em">|*NAME*|, </td>
//           </tr>
//           <tr bgcolor="#4DC01D">
//              <td align="center" class="title" style="font-size: 3.25em; line-height: 1.1em; font-family: \'Lato\', Arial; font-weight: 300; padding-left: 7%; padding-right: 7%"> You haven`t finished setting a campaign</td>
//           </tr>
//           <tr bgcolor="#4DC01D">
//              <td align="center" style="font-size: 1.875em; font-family: \'Lato\', Arial; font-weight: 300; line-height: 1.1em; padding: 40px 7% 70px 7%">We noticed that your campaign setup is in-complete </td>
//           </tr>
//         </thead>
//         <tbody>
//
//
//            <tr>
//               <td bgcolor="#ffffff" class="pl11" style="color: #252525; font-size: 1.875em; font-family: \'Lato\', Arial; font-weight: 300; padding-top: 2em; padding-right: 5%; padding-left: 5%; margin: 0">Complete your campaign</td>
//            </tr>
//            <tr>
//              <td bgcolor="#ffffff" class="pl11" style="font-size: 1.25em; color: #252525; font-family: \'Lato\', Arial; font-weight: 300; padding-top: 0.6em; padding-right: 5%; padding-left: 5%; padding-bottom: 0.9em;">
//                   Login to your <a href="https://setup-campaign.seelocal.co.uk/" target="_blank" style="color: #4DC01D; font-family: \'Lato\', Arial; font-weight: 300; line-height: 1.1em; text-decoration: none">account dashboard</a> to complete your campaign setup, it should only take 10 minutes!
//               </td>
//            </tr>
//            <tr>
//              <td bgcolor="#ffffff" class="pl11" style="padding: 3.5em 5% 4.5em 5%;">
//                   <table border="0" cellpadding="0" cellspacing="0" style="width: 218px; "  >
//                    <!-- style="width: 218px; background: #02516C; border-radius: 30px; -webkit-border-radius: 30px;" -->
//                     <tr>
//                       <td style="height: 50px; background: #02516C; text-decoration: none; border-radius: 30px; -webkit-border-radius: 30px; text-align: center;">
//                        <!-- text-decoration: none; background: blue; color: white;  padding-top: 0.9em; padding-bottom: 0.9em; text-align: center; width: 100% -->
//                         <a target="_blank"  style="text-decoration: none; font-family: \'Lato\', Arial; font-size: 1.25em; font-weight: 300; color: white;" href="#">Complete campaign</a>
//                       </td>
//                     </tr>
//                   </table>
//              </td>
//            </tr>
//
//
//            <tr bgcolor="#02516C">
//              <td align="center" bgcolor="#02516C" style="font-size: 1.875em; font-family: \'Lato\', Arial; font-weight: 300; padding: 1.5em 7% 0.7em 7%; margin: 0; color: white">Thanks, from the Seelocal team
//              </td>
//            </tr>
//            <tr bgcolor="#02516C">
//              <td align="center" bgcolor="#02516C" style="color: white; font-family: \'Lato\', Arial; font-weight: 300; font-size: 1.25em; line-height: 1.1em; padding: 0.1% 7% 2.7em 7%">
//                If you have any questions regarding your campaign get in touch with a member of our team on <span style="white-space: nowrap">01295 817 638</span>
//              </td>
//            </tr>
//            <tr bgcolor="#424041">
//              <td  align="center" style="color: white; font-family: \'Lato\', Arial;font-weight: 300; font-size: 1em; padding: 1.25em 7%">
//                 Copyright &copy; 2016, SeeLocal Ltd, All rights reserved
//              </td>
//            </tr>
//         </tbody>
//    </table>
//  </body>
//</html>
//';
//
//        $headers = 'MIME-Version: 1.0' . "\r\n";
//        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//        $headers .= 'From: Seelocal <admin@setup-campaign.seelocal.co.uk>' . "\r\n";
//        $headers .= 'X-Mailer: PHP/' . phpversion();
//        if (mail($to, 'Notification', $email_html, $headers)) {}
////        if (mail($to2, 'Notification', $email_html, $headers)) {}
//
//
////***************************************************************************************************
//// Confirmation
//        $name_line = $demografics_line = $location_line = $objectve_line = $promotion_line = $campaing_type = $campaing_option = $campaing_dates = $campaing_price = $payment_name = $payment_card_number = $payment_exp_date = 'test';
//        $html = '
//<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
//<html>
//  <head>
//    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
//    <title>seelocal | Confirmation</title>
//    <link href=\'https://fonts.googleapis.com/css?family=Lato:400,600,700,300\' rel=\'stylesheet\' type=\'text/css\'>
//    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
//      <style>
//        @media only screen and (min-width: 640px) {
//          td>img[class="logo"] {
//            width: 350px!important;
//          }
//          table[class="t83"] {
//            width: 83%!important;
//          }
//            table[class="t82"] {
//            width: 82%!important;
//          }
//            table[class="t85"] {
//            width: 85%!important;
//          }
//            table[class="t74"] {
//            width: 74%!important;
//          }
//            table[class="t78"] {
//            width: 78%!important;
//          }
//            table[class="t95"] {
//            width: 95%!important;
//          }
//             table[class="t75"] {
//            width: 75%!important;
//          }
//             table[class="t90"] {
//            width: 90%!important;
//          }
//            table[class="t93"] {
//            width: 93%!important;
//          }
//            td[class="pl5"] {
//              padding-left: 5%!important;
//            }
//          td[class="pl11"] {
//              padding-left: 11%!important;
//            }
//
//        }
//
//        @media only screen and (max-width: 1900px) {
//          td[class="table-text"] {
//            font-size: 1.25em!important;
//          }
//        }
//       @media only screen and (max-width: 640px) {
//          td[class="table-text"] {
//            font-size: 1em!important;
//          }
//        }
//
//        @media only screen and (max-width: 640px) {
//          table[class="main"] {
//            font-size: 90%!important;
//          }
//          td[class="title"] {
//            font-size: 2.5em!important;
//          }
//        }
//    </style>
//  </head>
//  <body style="margin: 0">
//
//    <table class="main" border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; font-size: 100%; color: white; background: white; font-family: Lato, Arial; font-weight: 300 " width="100%">
//         <thead bgcolor="#4DC01D">
//
//            <tr bgcolor="#4DC01D">
//              <td align="right" style=" padding: 1.3%">
//                <a href="#" target="_blank" style="font-size: 1.1em; font-family: \'Lato\', Arial; font-weight: 300; letter-spacing: 1px; text-decoration: none; color: white; display: block;" >View this email in your browser</a>
//              </td>
//           </tr>
//
//           <tr bgcolor="#4DC01D">
//              <td style=" padding: 0.5em 4.5%">
//                   <img class="logo" src="http://drive.google.com/uc?export=view&id=0B77LwrVTKM9YMUp2SzdsXzN4Qkk" alt="logo-company" border="0" width="270" style="display:block">
//              </td>
//           </tr>
//
//           <tr bgcolor="#4DC01D">
//              <td align="center" class="title" style="font-size: 2.9em; font-family: \'Lato\', Arial; font-weight: 300; padding-top: 5.5%; padding-right: 7%; padding-left: 7%; line-height: 1.3em">'.$name_line.', </td>
//           </tr>
//
//           <tr bgcolor="#4DC01D">
//              <td align="center" class="title" style="font-size: 2.9em; line-height: 1.1em; font-family: \'Lato\', Arial; font-weight: 300; padding-left: 7%; padding-right: 7%"> Thank you for setting up a campaign</td>
//           </tr>
//
//           <tr bgcolor="#4DC01D">
//              <td align="center" style="line-height: 1.1em;font-size: 1.5em; font-family: \'Lato\', Arial; font-weight: 300; background: #4DC01D;  padding: 15px 7% 35px 7%;">Below are your campaign details, receipt & the next steps </td>
//           </tr>
//         </thead>
//         <tbody>
//            <tr>
//              <td align="center" style="background: white">
//                <table border="0" cellpadding="0" cellspacing="0"  class="t82" style="width: 90%; margin: 0 auto; background: white; max-width: 1242px; ">
//                  <tr>
//                   <td bgcolor="#ffffff" class="pl5" style="color: #252525; font-size: 1.5em; font-family: \'Lato\', Arial; font-weight: 300; padding-top: 2.1em; padding-bottom: 1.4em; margin: 0; color: #252525;">Your campaign details</td>
//                   </tr>
//                </table>
//              </td>
//            </tr>
//
//            <tr>
//              <td align="center" style="background: white; padding-bottom: 30px;">
//                <table border="0" cellpadding="0" cellspacing="0" class="t74" style="width: 90%; background: white; max-width: 1115px; margin: 0 auto;">
//                  <tr>
//                    <td>
//                      <table border="0" cellpadding="0" cellspacing="0" style="border-bottom: 1px dashed  #b7b6b6; width: 100%; font-family: Lato, Arial; font-weight: 300; font-size: 0.95em; color: #252525; padding-top: 0.8em;
//    padding-bottom: 0.8em;">
//                        <tr>
//                          <td style="width: 185px; font-family: Lato; font-weight: 300; color: #252525;">Demographics</td>
//                          <td style="font-family: Lato; font-weight: 300; color: #252525;">'.$demografics_line.'</td>
//                        </tr>
//                      </table>
//                    </td>
//                  </tr>
//                  <tr>
//                    <td>
//                      <table border="0" cellpadding="0" cellspacing="0" style="border-bottom: 1px dashed  #b7b6b6; width: 100%; font-family: Lato, Arial; font-weight: 300; color: #252525; padding-top: 0.8em;
//    padding-bottom: 0.8em;">
//                        <tr>
//                          <td style="width: 185px; font-family: Lato; font-size: 0.95em; font-weight: 300; color: #252525;">Location</td>
//                          <td style="font-family: Lato; font-weight: 300; font-size: 0.95em; color: #252525;">'.$location_line.'</td>
//                         </tr>
//                      </table>
//                    </td>
//                  </tr>
//                  <tr>
//                    <td>
//                      <table border="0" cellpadding="0" cellspacing="0" style="border-bottom: 1px dashed  #b7b6b6; width: 100%; font-family: Lato, Arial; font-weight: 300; font-size: 0.95em; color: #252525; padding-top: 0.8em;
//    padding-bottom: 0.8em;">
//                        <tr>
//                          <td style="width: 185px; font-family: Lato; font-weight: 300; color: #252525;">Objective</td>
//                          <td style="font-family: Lato; font-weight: 300; color: #252525;">'.$objectve_line.'</td>
//                        </tr>
//                      </table>
//                    </td>
//                  </tr>
//                  <tr>
//                    <td>
//                      <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; font-family: Lato, Arial; font-weight: 300; font-size: 0.95em; color: #252525; margin-bottom: 0.4em; padding-top: 0.8em;   padding-bottom: 0.8em;">
//                        <tr>
//                          <td style="width: 185px; font-family: Lato; font-weight: 300; color: #252525;">Promotion</td>
//                          <td style="font-family: Lato; font-weight: 300; color: #252525;">'.$promotion_line.'</td>
//                        </tr>
//                      </table>
//                    </td>
//                  </tr>
//                </table>
//              </td>
//            </tr>
//
//           <tr>
//              <td align="center" style="background: white">
//                <table  bgcolor="#F6F6F6" class="t83" border="0" cellpadding="0" cellspacing="0"  width="95%" style="margin: 0 auto; font-family: Lato, Arial; font-weight: 300; color: #252525; max-width: 1242px;">
//                  <tr>
//                    <td class="pl5" style="font-size: 1.5em; padding: 1em 0% 1em 2.5%; font-family: Lato; font-weight: 300">
//                        Your recent campaign order
//                    </td>
//                </tr>
//                </table>
//              </td>
//            </tr>
//
//          <tr>
//            <td align="center">
//              <table bgcolor="#F6F6F6" border="0" cellpadding="0" cellspacing="0" class="t83" style="width: 95%; margin: 0 auto; padding-top: 0.55em; max-width: 1242px;">
//                <tr>
//                  <td align="center">
//                    <table bgcolor="#F6F6F6" border="0" cellpadding="0" cellspacing="0" class="t90" style="width: 97%; margin: 0 auto; font-family: Lato, Arial; font-weight: 300; max-width: 1125px; color: #252525;">
//                      <tr>
//                        <td width="20%" >
//                          <table  border="0" cellpadding="0" width="98%" cellspacing="0" style="font-family: Lato, Arial; font-weight: 300; text-align: center;">
//                            <tr>
//                              <td class="table-text" style="font-size: 0.85em; background: #02516C; color: white; height: 56px;font-family: Lato; font-weight: 300 ">Campaign type</td>
//                            </tr>
//                            <tr>
//                            <td class="table-text" style="font-size: 0.85em; background: white; color: #252525; height: 86px;font-family: Lato; font-weight: 300">'.$campaing_type.'</td>
//                            </tr>
//                          </table>
//                        </td>
//                         <td width="20%">
//                          <table border="0" cellpadding="0" width="98%" cellspacing="0" style=" font-family: Lato, Arial; max-width: 1132px;font-weight: 300;text-align: center">
//                            <tr>
//                              <td class="table-text" style="font-size: 0.85em; background: #02516C; color: white; height: 56px;font-family: Lato; font-weight: 300 ">Campaign option</td>
//                            </tr>
//                            <tr>
//                            <td class="table-text" style="font-size: 0.85em; background: white; color: #252525;height: 86px; font-family: Lato; font-weight: 300 ">'.$campaing_option.'</td>
//                            </tr>
//                          </table >
//                        </td>
//                         <td width="20%">
//                          <table border="0" cellpadding="0" width="98%" cellspacing="0" style=" font-family: Lato, Arial; font-weight: 300; text-align: center">
//                            <tr>
//                              <td class="table-text" style="font-size: 0.85em; background: #02516C; color: white; font-family: Lato; font-weight: 300; height: 56px; ">Launch & end dates</td>
//                            </tr>
//                            <tr>
//                            <td class="table-text" style="font-size: 0.85em; background: white; font-family: Lato; font-weight: 300; color: #252525;height: 86px">'.$campaing_dates.'</td>
//                            </tr>
//                          </table>
//                        </td>
//                         <td width="20%">
//                          <table border="0" cellpadding="0" width="100%" cellspacing="0" style=" font-family: Lato, Arial; font-weight: 300; text-align: center">
//                            <tr>
//                              <td class="table-text" style="font-size: 0.85em; font-family: Lato; font-weight: 300; background: #02516C; color: white; height: 56px; ">Cost</td>
//                            </tr>
//                            <tr>
//                            <td class="table-text" style="font-size: 0.85em; background: white; font-family: Lato; color: #4dc01d; font-weight: 600; height: 86px">&pound;'.$campaing_price.'</td>
//                            </tr>
//                          </table>
//                        </td>
//                      </tr>
//                    </table>
//                    </td>
//                  </tr>
//                 </table>
//                </td>
//              </tr>
//
//            <tr>
//              <td align="center" style="padding-bottom: 15px;">
//                <table bgcolor="#F6F6F6" border="0" cellpadding="0" cellspacing="0"  class="t83" style="width: 95%; max-width: 1242px; margin: 0 auto; ">
//                  <tr>
//                    <td>
//                      <table  width="100%" bgcolor="#F6F6F6" border="0" cellpadding="0" cellspacing="0" >
//                         <tr>
//                           <td  class="pl5" style="color: #252525; font-size: 1.5em; font-family: \'Lato\', Arial; font-weight: 300; padding: 1.2em 2.5% 0.7em 2.5%; margin: 0; ">Payment details</td>
//                        </tr>
//                      </table>
//                    </td>
//                  </tr>
//
//                  <tr>
//                    <td align="center" style="padding-bottom: 25px;">
//                      <table border="0" cellpadding="0" cellspacing="0" class="t90" width="95%" style="margin: 0 auto">
//                        <tr>
//                          <td>
//                          <table  bgcolor="#F6F6F6" border="0" cellpadding="0" cellspacing="0" style="border-bottom: 1px dashed  #b7b6b6; width: 100%; font-family: Lato, Arial; font-weight: 300; font-size: 0.95em; max-width: 562px; color: #252525; padding-bottom: 0.8em; padding-top: 0.8em">
//                            <tr>
//                              <td style="width: 210px; padding-right: 4%; font-family: Lato; font-weight: 300">Cardholders name</td>
//                              <td style="font-family: Lato; font-weight: 300">'.$payment_name.'</td>
//                            </tr>
//                          </table>
//                        </td>
//                      </tr>
//                      <tr>
//                        <td>
//                          <table  bgcolor="#F6F6F6" border="0" cellpadding="0" cellspacing="0" style="border-bottom: 1px dashed  #b7b6b6; width: 100%; font-family: Lato, Arial; font-weight: 300; font-size: 0.95em; max-width: 562px; color: #252525; padding-bottom: 0.8em; padding-top: 0.8em; font-size: 0.95em">
//                            <tr>
//                              <td style="width: 210px; padding-right: 4%;font-family: Lato; font-weight: 300">Card number</td>
//                              <td style="font-family: Lato; font-weight: 300">'.$payment_card_number.'</td>
//                             </tr>
//                          </table>
//                        </td>
//                      </tr>
//                      <tr>
//                        <td>
//                          <table   bgcolor="#F6F6F6" border="0" cellpadding="0" cellspacing="0" style="width: 100%; font-family: Lato, Arial; font-weight: 300; font-size: 0.95em; color: #252525; max-width: 562px; padding-bottom: 0.8em; padding-top: 0.8em;">
//                            <tr>
//                              <td style="width: 210px; padding-right: 4%;font-family: Lato; font-weight: 300">Expiry date</td>
//                              <td style="font-family: Lato; font-weight: 300">'.$payment_exp_date.'</td>
//                            </tr>
//                          </table>
//                        </td>
//                      </tr>
//                    </table>
//                  </td>
//                </tr>
//              </table>
//                </td>
//              </tr>
//            </tbody>
//          </table>
//      <!--   </td>
//      </tr>  -->
//      <table width="100%" style="background: white" border="0" cellpadding="0" cellspacing="0">
//      <tr>
//        <td align="center" style="padding-top: 2.5em; padding-bottom: 2.5em">
//          <table border="0" cellpadding="0" cellspacing="0" class="t75" style="width: 90%; margin: 0 auto; color: #252525; font-family: Lato, Arial; font-weight: 300; background:white; max-width: 1115px; ">
//            <tr style="">
//               <td style="color: #252525; font-size: 1.5em; padding-bottom:  25px; font-family: Lato; font-weight: 300">What happens next?</td>
//             </tr>
//             <tr>
//               <td style="color: #252525; font-size: 0.95em; line-height: 1.5em; font-family: Lato; font-weight: 300">
//               In the next 1-2 working days we will send you a set of 6 display ads using the images and content that you provided,
//we will also send a link to your landing page.
//              </td>
//             </tr>
//             <tr>
//               <td style="color: #252525; font-size: 0.95em; line-height: 1.5em; padding-top: 25px; font-family: Lato; font-weight: 300">If you don`t receive anything from us, please contact us on <a style="color: #4dc01d; text-decoration: none; white-space: nowrap" href="tel:01295817638"> 01295 817 638</a></td>
//             </tr>
//               </table>
//             </td>
//       </tr>
//
//            <tr bgcolor="#02516C">
//              <td align="center" bgcolor="#02516C" style="font-size: 1.5em; font-family: \'Lato\', Arial; font-weight: 300; padding: 1.5em 7% 0.7em 7%; margin: 0; color: white">Thanks, from the Seelocal team
//              </td>
//            </tr>
//            <tr bgcolor="#02516C">
//              <td align="center" bgcolor="#02516C" style="color: white; font-family: \'Lato\', Arial; font-weight: 300; font-size: 0.95em; line-height: 1.1em; padding: 5px 7% 2.7em 7%">
//                If you have any questions regarding your campaign get in touch with a member of our team on <span style="white-space: nowrap">01295 817 638</span>
//              </td>
//            </tr>
//            <tr bgcolor="#424041">
//              <td  align="center" style="color: white; font-family: \'Lato\', Arial;font-weight: 300; font-size: 0.85em; padding: 1.25em 7%">
//                 Copyright &copy; 2016, SeeLocal Ltd, All rights reserved
//              </td>
//            </tr>
//    </table>
//  </body>
//</html>
//';
//        $headers  = 'MIME-Version: 1.0' . "\r\n";
//        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//        $headers .= 'From: Seelocal <admin@setup-campaign.seelocal.co.uk>' . "\r\n";
//        $headers .= 'X-Mailer: PHP/' . phpversion();
//        if( mail($to, 'Confirm campaign', $html, $headers) ){}
////        if( mail($to2, 'Confirm campaing', $html, $headers) ){}
//
//    }




public function mail_confirm(){

//    $d = base64_encode(json_encode(
//            array(
//                'name_line'=>'Eugene',
//                'demografics_line' => 'Male & Female, 18-65',
//                'location_line' => 'Banbury + 5 Mile Radius',
//                'objectve_line' => 'Footfall',
//                'promotion_line' => 'Signup Now & Get 20% Off in May',
//                'campaing_type' => 'Subscription campaign',
//                'campaing_option' => 'Expert',
//                'campaing_dates' => '23.04.16 - 23.07.16',
//                'campaing_price' => '7,699',
//                'payment_name' => 'Laura Tilley',
//                'payment_card_number' => 'XXXX-XXXX-XXXX-8364',
//                'payment_exp_date' => '12/17'
//            ))
//    );

    if(json_decode(base64_decode($_SERVER['QUERY_STRING'])) == null){
        return view('layouts.error');
    }
    $data = json_decode(base64_decode($_SERVER['QUERY_STRING']));
    return view('layouts.mail_confirm')->with([
        'name_line'=>$data->name_line,
        'demografics_line'=>$data->demografics_line,
        'location_line'=>$data->location_line,
        'objectve_line'=>$data->objectve_line,
        'promotion_line'=>$data->promotion_line,
        'campaing_type'=>$data->campaing_type,
        'campaing_option'=>$data->campaing_option,
        'campaing_dates'=>$data->campaing_dates,
        'campaing_price'=>$data->campaing_price,
        'payment_name'=>$data->payment_name,
        'payment_card_number'=>$data->payment_card_number,
        'payment_exp_date'=>$data->payment_exp_date
    ]);
}

public function mail_registration(){ //https://setup-campaign.seelocal.co.uk/mail/registration?eyJuYW1lIjoiRXVnZW5lIiwibWFpbCI6ImRqc3RyZWV0MTFAZ21haWwuY29tIn0=
//    $d = base64_encode(json_encode(
//            array(
//                'name'=>'Eugene',
//                'mail'=>'djstreet11@gmail.com',
//            ))
//    );
    if(json_decode(base64_decode($_SERVER['QUERY_STRING'])) == null){
        return view('layouts.error');
    }
    $data = json_decode(base64_decode($_SERVER['QUERY_STRING']));
    return view('layouts.mail_registration')->with([
        'name'=>$data->name,
        'email'=>$data->mail
    ]);
}

public function mail_cart(){
    if(json_decode(base64_decode($_SERVER['QUERY_STRING'])) == null){
        return view('layouts.error');
    }
    $data = json_decode(base64_decode($_SERVER['QUERY_STRING']));
    return view('layouts.mail_cart')->with([
        'name'=>$data->name
    ]);
}


//{{ dd(get_defined_vars()) }}

}
