<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('user_id');
            $table->string('address');
            $table->integer('time_periode');
            $table->string('type')->comment('hari/minggu/bulan');
            $table->string('type_payment');
            $table->string('payment_status');
            $table->string('status')->default(1)->comment('10 : peding, 20 : proses, 30 : sending : 40 : recived : 50 : return, 90 : cancel : 91 : payemt expired');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
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
        Schema::dropIfExists('rental_orders');
    }
}
