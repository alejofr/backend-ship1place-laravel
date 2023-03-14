<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id('city_id');
            $table->string('name');
            $table->unsignedBigInteger('province_id');
            $table->unsignedBigInteger('country_id');
            $table->timestamps();

            $table->foreign('country_id')
                ->references('country_id')
                ->on('countries')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            $table->foreign('province_id')
                ->references('province_id')
                ->on('provinces')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
};
