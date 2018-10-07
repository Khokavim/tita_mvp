<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buys', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('sell_id');
          $table->string('track_id')->nullable();
          $table->integer('buyer_id');
          $table->integer('seller_id');
          $table->integer('quantity');
          $table->integer('bid');
          $table->string('asset');
          $table->boolean('sold')->default(0);
          $table->boolean('verified');
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
        Schema::dropIfExists('buys');
    }
}
