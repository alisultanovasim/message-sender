<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Log;
use App\Logs;

/**
 * @OA\Schema (
 *     title="Message",
 *     description="Messages model",
 *     type="object",
 *     schema="Message"
 * )
 */
class Message extends Model
{
    protected $table="messages";
    const STATUS_SEND=1;
    const STATUS_REJECT=2;

    public function company()
    {
         return $this->hasOne(Companies::class, 'id', 'c_id');
    }
    public function chatType()
    {
         return $this->hasOne(ChatType::class, 'id', 'chat_type_id');
    }
    public function sendStatus()
    {
         return $this->hasOne(SendStatus::class, 'id', 'send_status_id');
    }
    public function messageStatus()
    {
         return $this->hasOne(MessageStatus::class, 'id', 'message_status_id');
    }
    public function priority()
    {
         return $this->hasOne(Priority::class, 'id', 'priority_id');
    }
    public function environment()
    {
         return $this->hasOne(Environment::class, 'id', 'priority_id');
    }
    // send sms
    public function sendMessage($c_id,$phone_number,$text,$type)
    {
        $company=Companies::where('id',$c_id)->first();
        $curl = curl_init();
        if($company)
        {
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://api.ultramsg.com/".$company->c_instance_id."/messages/chat",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_SSL_VERIFYHOST => 0,
              CURLOPT_SSL_VERIFYPEER => 0,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => "token=".$company->c_token."&to=+".$phone_number."&body=".$text."&priority=1&referenceId=",
              CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
              ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
            Log::info('Company request-'.$response);
            Logs::insert([
                     'companies_name'=>$company->c_name,
                     'log_type'=>$type==1 ? 'Send_message' : 'Send_message_system',
                     'log_text'=>'To send_number:'.$phone_number.', from whatsap_number:'.$company->c_whatsapp_number.', message: '.$text.',Company: '. $company->id.', accept request-'.$response,
                     'ip'=>getServerIp(),

                ]);
            $response=json_decode($response,true);
            $messageid=0;
            if(!empty($response['message']) && $response['message']=='ok')
            {

                $messageid=Message::insertGetId([
                    'c_id'=>$company->id,
                    'from_message'=>$company->c_whatsapp_number,
                    'to_message'=>$phone_number,
                    'body_message'=>$text,
                    'chat_type_id'=>1,
                    'send_status_id'=>1,
                    'priority_id'=>1,
                    'message_created_at'=>date('Y-m-d H:i:s'),
                    'message_sent_at'=>date('Y-m-d H:i:s'),
                    'ip'=>getServerIp(),
                    'message_status_id'=>2,
                    'whatsapp_message_id'=>$response['id'],
                    'message_type'=>$type
                    ]);

            }

            return $messageid;
            if ($err) {
              echo "cURL Error #:" . $err;
            } else {
              echo $response;
            }
        }
    }



    // get statics
    public function getSendStatics($c_id)
    {
        $company=Companies::where('id',$c_id)->first();
        if($company)
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://api.ultramsg.com/".$company->c_instance_id."/messages/statistics?token=".$company->c_token,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_SSL_VERIFYHOST => 0,
              CURLOPT_SSL_VERIFYPEER => 0,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
              ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            return json_decode($response,true);
        }
        return false;
    }

    //check whatsapp number
    public function checkWhatsappNumber($c_id)
    {
        $company=Companies::where('id',$c_id)->first();
        if($company)
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://api.ultramsg.com/".$company->c_instance_id."/instance/status?token=".$company->c_token,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_SSL_VERIFYHOST => 0,
              CURLOPT_SSL_VERIFYPEER => 0,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
              ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            $message= json_decode($response,true);
            if(!empty($message['status']['accountStatus']['status']))
            {
                if($message['status']['accountStatus']['status'] == "authenticated")
                {
                    return 1;
                }else
                {
                    return 2;
                }
            }else {
                return 2;
            }
        }
        return false;
    }


    public function checkNumberProfile($c_id)
    {
        $company=Companies::where('id',$c_id)->first();
        if($company)
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://api.ultramsg.com/".$company->c_instance_id."/instance/me?token=".$company->c_token,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_SSL_VERIFYHOST => 0,
              CURLOPT_SSL_VERIFYPEER => 0,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
              ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            $message= json_decode($response,true);
            return $message;
        }
        return false;
    }

    public function scopeDateFilter($query,$from,$to)
    {
        return $query
            ->whereDate('message_sent_at','>=',$from)
            ->whereDate('message_sent_at','<=',$to)
            ->count();
    }



}
