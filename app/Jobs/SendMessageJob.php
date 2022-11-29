<?php

namespace App\Jobs;

use App\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $numbers=[];
    public $message='aaa';
    public function __construct($numbers,$message)
    {
        $this->numbers=$numbers;
        $this->message=$message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
     foreach ($this->numbers as $number){
         $message=new Message();
         $message->sendMessage(1,$number->phone_number,$this->message,1);
     }

    }
}
