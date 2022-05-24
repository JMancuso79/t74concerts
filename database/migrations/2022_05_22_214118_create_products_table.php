<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('name');
            $table->string('slug');
            $table->string('short_description')->nullable();
            $table->string('description')->nullable();
            $table->integer('inventory')->default(0);
            $table->string('sizes')->nullable();
            $table->string('colors')->nullable();
            $table->string('price');
            $table->string('tags')->nullable();
            $table->string('category');
            $table->string('promo_codes')->nullable();
            $table->string('status')->default('not-published');
            $table->string('image')->nullable();
            $table->integer('featured')->default(0);
            $table->integer('concert_id')->default(0);
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
        Schema::dropIfExists('products');
    }
}
