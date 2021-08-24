<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingPaymentXenditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_payment_xendits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('xendit_id');
            $table->string('external_id');
            $table->string('payment_method');
            $table->string('status',25);
            $table->unsignedInteger('paid_amount');
            $table->unsignedInteger('adjusted_received_amount');
            $table->unsignedInteger('fees_paid_amount');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_payment_xendits');
    }
}
