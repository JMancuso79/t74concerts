<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_name');
            $table->string('email');
            $table->string('type');
            $table->string('phone');
            $table->string('address')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->integer('gig_swap')->default(0);
            $table->string('gig_swap_home')->nullable();
            $table->string('gig_swap_away')->nullable();
            $table->string('message');
            $table->string('url')->nullable();
            $table->string('genres');
            $table->string('dates')->nullable();    
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
        Schema::dropIfExists('booking_requests');
    }
}
