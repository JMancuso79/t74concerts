<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_payment_id');
            $table->string('name_on_card');
            $table->string('ticket_holder');
            $table->string('email');
            $table->string('phone');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->integer('num_of_tickets');
            $table->integer('price_per_ticket');
            $table->integer('total_sale');
            $table->integer('concert_id');
            $table->string('concert_title');
            $table->string('concert_date');
            $table->string('venue');
            $table->string('venue_city');
            $table->string('venue_state');
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
        Schema::dropIfExists('orders');
    }
}
