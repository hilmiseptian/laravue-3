<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLkCity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lk_city', function (Blueprint $table) {
            $table->id('city_id');
            $table->integer('province_id');
            $table->string('province');
            $table->string('type');
            $table->string('city_name');
            $table->string('postal_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lk_city');
    }
}
