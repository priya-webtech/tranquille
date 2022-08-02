<?php

namespace App\Console\Commands;

use App\Models\Membership;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckExpiryCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check-expiry:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        Log::info("Cron is working fine!");
        $tenDaysAgo = Carbon::now()->subDays(10);
        $expireMemberShip = Membership::whereDate('end_date', $tenDaysAgo)->get();

        if (count($expireMemberShip)>0){
            foreach ($expireMemberShip as $memberShip){
                $notification = new Notification();
                $notification->title = 'Membership expire';
                $notification->message = 'Your Membership will get expire in 10 day';
                $notification->type = 'Membership Plan';
                $notification->user_id  = $memberShip->user_id;
                $notification->type_id  = $memberShip->id;
                $notification->created_at = date('d-m-Y H:i:s');
                $notification->save();
            }
        }
    }
}
