<?php

namespace App\Console\Commands;

use App\Jobs\SendMessageJob;
use App\TestMessage;
use Illuminate\Console\Command;
use App\Companies;
use App\Message;
use App\MessageSendStatus;
use App\Crons;
use Illuminate\Support\Facades\Artisan;

class QueueCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Queue Status loading';

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
        Artisan::call('queue:work');
        $this->info('Job was turned on');
    }
}
