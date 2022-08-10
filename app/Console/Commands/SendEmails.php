<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send e-mails to a user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
     
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
		{

		$data = DB::connection('user_steps')->table('user_info')->select('user_id','last_activ','id')
            ->where('last_activ','<=',strtotime('-6 hour'))
            ->where('first_send','0')
            ->get();
// 		$this->info(json_encode($data));
// 		$this->info(json_encode(''));
		$n = sizeof($data);
		if($n > 0){
		
		$email_html = '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>seelocal | Abandoned cart</title> 

<link href=\'https://fonts.googleapis.com/css?family=Lato:400,600,700,300\' rel=\'stylesheet\' type=\'text/css\'>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">    
  </head>
  <body style="margin: 0">  
  <style> 
@media only screen and (min-width: 640px) {
  td>img[class="logo"] {
    width: 350px!important;
  }
}

@media only screen and (max-width: 640px) {
  table {
    font-size: 90%!important;
  }
  td[class="title"] {
    font-size: 2.5em!important;
  }
}
 
@media only screen and (max-width: 1900px) {
  td[class="pl11"] {
    padding-left: 11.5%!important;
    padding-right: 11.5%!important;
  } 
}

  </style>   
    <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; font-size: 100%; color: white; font-family: Lato, Arial; font-weight: 300 " width="100%">
         <thead bgcolor="#4DC01D">
            <tr bgcolor="#4DC01D">
              <td align="right" style=" padding: 1.3%"> 
                <a href="https://setup-campaign.seelocal.co.uk/mail/registration?|*INBR*|" target="_blank" style="font-size: 1.1em; font-family: \'Lato\', Arial; font-weight: 300; letter-spacing: 1px; text-decoration: none; color: white; display: block;" >View this email in brower</a>
              </td>
           </tr>
           <tr bgcolor="#4DC01D">
              <td style=" padding: 0.5em 4.5%"> 
                   <img class="logo" src="https://setup-campaign.seelocal.co.uk/images/logo-tr.png" alt="logo-company" border="0" width="270" style="display:block"> 
              </td>
           </tr>
           <tr bgcolor="#4DC01D">
              <td align="center" class="title" style="font-size: 3.25em; font-family: \'Lato\', Arial; font-weight: 300; padding-top: 5.5%; padding-right: 7%; padding-left: 7%; line-height: 1.3em">|*NAME*|, </td>
           </tr>
           <tr bgcolor="#4DC01D">
              <td align="center" class="title" style="font-size: 3.25em; line-height: 1.1em; font-family: \'Lato\', Arial; font-weight: 300; padding-left: 7%; padding-right: 7%"> You haven’t finished setting a campaign</td>
           </tr>
           <tr bgcolor="#4DC01D">
              <td align="center" style="font-size: 1.875em; font-family: \'Lato\', Arial; font-weight: 300; line-height: 1.1em; padding: 40px 7% 70px 7%">We noticed that your campaign setup is in-complete </td>
           </tr>
         </thead> 
         <tbody>
        

            <tr>
               <td bgcolor="#ffffff" class="pl11" style="color: #252525; font-size: 1.875em; font-family: \'Lato\', Arial; font-weight: 300; padding-top: 2em; padding-right: 5%; padding-left: 5%; margin: 0">Complete your campaign</td>
            </tr>
            <tr>
              <td bgcolor="#ffffff" class="pl11" style="font-size: 1.25em; color: #252525; font-family: \'Lato\', Arial; font-weight: 300; padding-top: 0.6em; padding-right: 5%; padding-left: 5%; padding-bottom: 0.9em;">                  
                   Login to your <a href="https://setup-campaign.seelocal.co.uk/" target="_blank" style="color: #4DC01D; font-family: \'Lato\', Arial; font-weight: 300; line-height: 1.1em; text-decoration: none">account dashboard</a> to complete your campaign setup, it should only take 10 minutes!
               </td>
            </tr>
            <tr>
              <td bgcolor="#ffffff" class="pl11" style="padding: 3.5em 5% 4.5em 5%;">  
                   <table border="0" cellpadding="0" cellspacing="0" style="width: 218px; "  >
                    <!-- style="width: 218px; background: #02516C; border-radius: 30px; -webkit-border-radius: 30px;" -->
                     <tr>
                       <td style="height: 50px; background: #02516C; text-decoration: none; border-radius: 30px; -webkit-border-radius: 30px; text-align: center;">
                        <!-- text-decoration: none; background: blue; color: white;  padding-top: 0.9em; padding-bottom: 0.9em; text-align: center; width: 100% -->
                         <a target="_blank"  style="text-decoration: none; font-family: \'Lato\', Arial; font-size: 1.25em; font-weight: 300; color: white;" href="#">Complete campaign</a>  
                       </td>
                     </tr>
                   </table>
              </td>
            </tr>


            <tr bgcolor="#02516C">
              <td align="center" bgcolor="#02516C" style="font-size: 1.875em; font-family: \'Lato\', Arial; font-weight: 300; padding: 1.5em 7% 0.7em 7%; margin: 0; color: white">Thanks, from the Seelocal team 
              </td>
            </tr>
            <tr bgcolor="#02516C">
              <td align="center" bgcolor="#02516C" style="color: white; font-family: \'Lato\', Arial; font-weight: 300; font-size: 1.25em; line-height: 1.1em; padding: 0.1% 7% 2.7em 7%">
                If you have any questions regarding your campaign get in touch with a member of our team on <span style="white-space: nowrap">01295 817 638</span>
              </td>
            </tr>
            <tr bgcolor="#424041">
              <td  align="center" style="color: white; font-family: \'Lato\', Arial;font-weight: 300; font-size: 1em; padding: 1.25em 7%">
                 Copyright © 2016, SeeLocal Ltd, All rights reserved
              </td>
            </tr>
         </tbody>
    </table> 
  </body>
</html>
';
		
		
		
		
		
		
		
		
		
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: noreply@setup-campaign.seelocal.co.uk' . "\r\n";
			$headers .= 'X-Mailer: PHP/' . phpversion();
			for($i=0; $i<$n; ++$i){
			
				$user = DB::table('user_management')->select('first_name','email')->where('id','=',$data[$i]->user_id)->get();

                $in_browser = base64_encode(json_encode(
                        array(
                            'name'=>$user[0]->first_name
                        ))
                );
                $html_tmp1 = str_replace('|*INBR*|', $in_browser, $email_html);
                $html_tmp = str_replace('|*NAME*|', $user[0]->first_name, $html_tmp1);
				if( mail($user[0]->email, 'Notification', $html_tmp, $headers) ){}
				
				DB::connection('user_steps')->table('user_info')->where('id', $data[$i]->id)->update(array('last_activ'	=> 	time(),'first_send'=>'1'));
			}
		}
// 		$this->info(json_encode('emails was sended '.time()));


            $data = DB::connection('user_steps')->table('user_info')->select('user_id','last_activ','id')
                ->where('last_activ','<=',strtotime('-48 hour'))
                ->where('first_send','1')
                ->get();
            $n = sizeof($data);
            if($n > 0){
//https://setup-campaign.seelocal.co.uk/mail/registration?eyJuYW1lIjoiRXVnZW5lIiwibWFpbCI6ImRqc3RyZWV0MTFAZ21haWwuY29tIn0=

                $email_html = '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>seelocal | Abandoned cart</title> 

<link href=\'https://fonts.googleapis.com/css?family=Lato:400,600,700,300\' rel=\'stylesheet\' type=\'text/css\'>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">    
  </head>
  <body style="margin: 0">  
  <style> 
@media only screen and (min-width: 640px) {
  td>img[class="logo"] {
    width: 350px!important;
  }
}

@media only screen and (max-width: 640px) {
  table {
    font-size: 90%!important;
  }
  td[class="title"] {
    font-size: 2.5em!important;
  }
}
 
@media only screen and (max-width: 1900px) {
  td[class="pl11"] {
    padding-left: 11.5%!important;
    padding-right: 11.5%!important;
  } 
}

  </style>   
    <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; font-size: 100%; color: white; font-family: Lato, Arial; font-weight: 300 " width="100%">
         <thead bgcolor="#4DC01D">
            <tr bgcolor="#4DC01D">
              <td align="right" style=" padding: 1.3%"> 
                <a href="https://setup-campaign.seelocal.co.uk/mail/registration?|*INBR*|" target="_blank" style="font-size: 1.1em; font-family: \'Lato\', Arial; font-weight: 300; letter-spacing: 1px; text-decoration: none; color: white; display: block;" >View this email in brower</a>
              </td>
           </tr>
           <tr bgcolor="#4DC01D">
              <td style=" padding: 0.5em 4.5%"> 
                   <img class="logo" src="https://setup-campaign.seelocal.co.uk/images/logo-tr.png" alt="logo-company" border="0" width="270" style="display:block"> 
              </td>
           </tr>
           <tr bgcolor="#4DC01D">
              <td align="center" class="title" style="font-size: 3.25em; font-family: \'Lato\', Arial; font-weight: 300; padding-top: 5.5%; padding-right: 7%; padding-left: 7%; line-height: 1.3em">|*NAME*|, </td>
           </tr>
           <tr bgcolor="#4DC01D">
              <td align="center" class="title" style="font-size: 3.25em; line-height: 1.1em; font-family: \'Lato\', Arial; font-weight: 300; padding-left: 7%; padding-right: 7%"> You haven’t finished setting a campaign</td>
           </tr>
           <tr bgcolor="#4DC01D">
              <td align="center" style="font-size: 1.875em; font-family: \'Lato\', Arial; font-weight: 300; line-height: 1.1em; padding: 40px 7% 70px 7%">We noticed that your campaign setup is in-complete </td>
           </tr>
         </thead> 
         <tbody>
        

            <tr>
               <td bgcolor="#ffffff" class="pl11" style="color: #252525; font-size: 1.875em; font-family: \'Lato\', Arial; font-weight: 300; padding-top: 2em; padding-right: 5%; padding-left: 5%; margin: 0">Complete your campaign</td>
            </tr>
            <tr>
              <td bgcolor="#ffffff" class="pl11" style="font-size: 1.25em; color: #252525; font-family: \'Lato\', Arial; font-weight: 300; padding-top: 0.6em; padding-right: 5%; padding-left: 5%; padding-bottom: 0.9em;">                  
                   Login to your <a href="https://setup-campaign.seelocal.co.uk/" target="_blank" style="color: #4DC01D; font-family: \'Lato\', Arial; font-weight: 300; line-height: 1.1em; text-decoration: none">account dashboard</a> to complete your campaign setup, it should only take 10 minutes!
               </td>
            </tr>
            <tr>
              <td bgcolor="#ffffff" class="pl11" style="padding: 3.5em 5% 4.5em 5%;">  
                   <table border="0" cellpadding="0" cellspacing="0" style="width: 218px; "  >
                    <!-- style="width: 218px; background: #02516C; border-radius: 30px; -webkit-border-radius: 30px;" -->
                     <tr>
                       <td style="height: 50px; background: #02516C; text-decoration: none; border-radius: 30px; -webkit-border-radius: 30px; text-align: center;">
                        <!-- text-decoration: none; background: blue; color: white;  padding-top: 0.9em; padding-bottom: 0.9em; text-align: center; width: 100% -->
                         <a target="_blank"  style="text-decoration: none; font-family: \'Lato\', Arial; font-size: 1.25em; font-weight: 300; color: white;" href="#">Complete campaign</a>  
                       </td>
                     </tr>
                   </table>
              </td>
            </tr>


            <tr bgcolor="#02516C">
              <td align="center" bgcolor="#02516C" style="font-size: 1.875em; font-family: \'Lato\', Arial; font-weight: 300; padding: 1.5em 7% 0.7em 7%; margin: 0; color: white">Thanks, from the Seelocal team 
              </td>
            </tr>
            <tr bgcolor="#02516C">
              <td align="center" bgcolor="#02516C" style="color: white; font-family: \'Lato\', Arial; font-weight: 300; font-size: 1.25em; line-height: 1.1em; padding: 0.1% 7% 2.7em 7%">
                If you have any questions regarding your campaign get in touch with a member of our team on <span style="white-space: nowrap">01295 817 638</span>
              </td>
            </tr>
            <tr bgcolor="#424041">
              <td  align="center" style="color: white; font-family: \'Lato\', Arial;font-weight: 300; font-size: 1em; padding: 1.25em 7%">
                 Copyright © 2016, SeeLocal Ltd, All rights reserved
              </td>
            </tr>
         </tbody>
    </table> 
  </body>
</html>
';









                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: Seelocal <admin@setup-campaign.seelocal.co.uk>' . "\r\n";
                $headers .= 'X-Mailer: PHP/' . phpversion();
                for($i=0; $i<$n; ++$i){

                    $user = DB::table('user_management')->select('first_name','email')->where('id','=',$data[$i]->user_id)->get();
                    $in_browser = base64_encode(json_encode(
                            array(
                                'name'=>$user[0]->first_name
                            ))
                    );
                    $html_tmp1 = str_replace('|*INBR*|', $in_browser, $email_html);
                    $html_tmp = str_replace('|*NAME*|', $user[0]->first_name, $html_tmp1);
                    if( mail($user[0]->email, 'Notification', $html_tmp, $headers) ){}

                    DB::connection('user_steps')->table('user_info')->where('id', $data[$i]->id)->update(array('last_activ'	=> 	time()));
                }
            }


    }
}
