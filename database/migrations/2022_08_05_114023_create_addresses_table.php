<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function () {
            Schema::create('addresses', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->integer('number');
                $table->unsignedBigInteger('city_id');
                $table->unsignedBigInteger('user_id');
                $table->timestamps();
            });

            Schema::table('addresses', function (Blueprint $table) {
                $table->foreign('city_id')->references('id')->on('cities');
                $table->foreign('user_id')->references('id')->on('users');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adresses');
    }
}
