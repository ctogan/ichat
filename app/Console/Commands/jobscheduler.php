<?php

namespace App\Console\Commands;

use App\Reedem;
use App\Voucher;
use Carbon\Carbon;
use Illuminate\Console\Command;

class jobscheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reedem:policy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'change status reedem older 10 minutes than now';

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
        $now = date('Y-m-d H:i:s');
        $reedem = Reedem::where('status','waiting')->get();

        $reedem_time = Carbon::createFromFormat('Y-m-d H:i:s', $reedem->created_at)->format('H:i:s');
        $reedem_time = Carbon::parse($reedem_time);
        $upload_time = Carbon::parse($now);
        $duration =  $reedem_time->diff($upload_time)->format('%I');

        if($duration > 10){
            $record = Reedem::where([
                ['id',$reedem->id],
            ])->update([
                'status'=> 'expired',
                'updated_at' => $now,
            ]);

            Voucher::where([
                ['id',$reedem->voucher_id],
            ])->update([
                'is_used'=> false,
                'updated_at' => $now,
            ]);
        }
    }
}
