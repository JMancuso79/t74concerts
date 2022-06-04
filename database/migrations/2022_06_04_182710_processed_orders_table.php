<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProcessedOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processed_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->default(0);
            $table->string('transaction_id');
            $table->string('total');
            $table->string('status');
            $table->string('promo_code')->nullable();
            $table->string('discount')->nullable();
            $table->string('delivery_method');
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
        //
    }
}
