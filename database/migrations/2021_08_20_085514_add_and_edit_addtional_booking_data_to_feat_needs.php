<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAndEditAddtionalBookingDataToFeatNeeds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('tourism_info_id')->after('place_id');
            $table->string('tourism_name')->after('tourism_info_id');
            $table->string('code_unique')->unique()->after('status');
            $table->unsignedInteger('grand_total')->after('code_unique');
            $table->dateTime('visit_time')->nullable()->after('grand_total');
            $table->string('url_qrcode')->after('grand_total');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
        });
    }
}
