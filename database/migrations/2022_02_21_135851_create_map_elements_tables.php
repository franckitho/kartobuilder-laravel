<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapElementsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_elements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('map_id');
            $table->foreign('map_id')->references('id')->on('maps');
            $table->string('name');
            $table->string('GeoJSON');
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
        Schema::dropIfExists('_map_elements_tables');
    }
}
