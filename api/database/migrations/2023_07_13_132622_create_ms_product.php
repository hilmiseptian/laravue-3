<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_product', function (Blueprint $table) {
            $table->id();
            $table->string('productName');
            $table->integer('categoryID');
            $table->integer('subCategoryID')->nullable();
            $table->string('image')->nullable();
            $table->string('notes')->nullable();
            $table->string('created_by');
            $table->string('edited_by')->nullable();
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
        Schema::dropIfExists('ms_product');
    }
}
