<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('consignee_id');
            $table->integer('driver_id')->nullable();
            $table->integer('user_id');
            $table->string('tracking_num')->nullable();
            $table->decimal('amount');
            $table->decimal('weight');
            $table->integer('no_pieces');
            $table->string('reference_num')->nullable();
            $table->dateTime('pickup_date');
            $table->dateTime('delivery_date');
            $table->longText('notes')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('bookings');
    }
}
