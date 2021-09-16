<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use DB;

class AutoExpireTicket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ulinyu:auto-expire-ticket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire Ticket when arrives date has exceed';

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
        $bookings = Booking::where('status',1)->where('visit_time','=',NULL)->where('date','<',$now)->get();

        DB::beginTransaction();
        try {     
            foreach ($bookings as $booking) {
                Log::debug($booking);
                $booking->status = 3;
                $booking->save();
            }
            DB::commit();
        }catch (Exception $e) {
            DB::rollBack();
            report($e);
        }

    }
}
