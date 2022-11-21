<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Companies;
use App\Message;
use App\MessageSendStatus;
use App\Crons;

class UnsentCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:unsent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unsent Status loading';

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
     * @return int
     */
    public function handle()
    {
        $companies=Companies::all();
        foreach($companies as $com)
        {
            $static=new Message();
            $static=$static->getSendStatics($com->id);
            if($static)
            {
                $count=$static['messages_statistics']['unsent'];
                if($count<=100)
                {
                    $page=1;
                }else
                {
                    $page=intval($count/100)+1;
                }
                for($i=1;$i<=$page;$i++)
                {
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                      CURLOPT_URL => "https://api.ultramsg.com/".$com->c_instance_id."/messages?token=".$com->c_token."&page=".$i."&limit=100&status=unsent",
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

                    Crons::insert([
                        'cron_name'=>'UnsentStatus',
                        'text'=>"log: ".$response
                        ]);
                    $response=json_decode($response,true);
                    if($response['messages'])
                    {
                        foreach($response['messages'] as $mess)
                        {
                            $message=Message::where('whatsapp_message_id',$mess['id'])->first();
                            if($message)
                            {
                                $sendstatus=MessageSendStatus::where('message_id',$message->id)->first();
                                if(!$sendstatus)
                                {
                                    MessageSendStatus::insert([
                                        'send_status_id'=>2,
                                        'message_id'=>$message->id,
                                        'send_date'=>date('Y-m-d H:i:s',$mess['sent_at'])
                                    ]);
                                    Message::where('whatsapp_message_id',$mess['id'])->update(['send_status_id'=>2]);
                                }
                            }
                        }
                    }
                    // if ($err) {
                    //   echo "cURL Error #:" . $err;
                    // } else {
                    //   echo $response;
                    // }
                }
            }

        }
        $this->info('Redaktə edildi');
    }
}
