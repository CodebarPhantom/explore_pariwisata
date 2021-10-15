<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;

class AutoVoidTicket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ulinyu:auto-void-ticket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Void Ticket when not taking action';

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
        $now = Carbon::now()->format('Y-m-d');
        $bookings = Booking::where('status',2)->where('created_at','<',$now)->get();

        DB::beginTransaction();
        try {     
            foreach ($bookings as $booking) {
                $booking->status = 0;
                $booking->save();
            }
            DB::commit();
        }catch (Exception $e) {
            DB::rollBack();
            report($e);
        }

    }
}
