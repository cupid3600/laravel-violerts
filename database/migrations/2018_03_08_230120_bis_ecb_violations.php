<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BisEcbViolations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bis_ecb_violations', function (Blueprint $table) { 
            $table->increments('id'); 
            $table->integer('property_id')->nullable(); 
            $table->string('ecb_number')->nullable();
            $table->string('uri')->nullable();
            $table->string('bvs_status')->nullable();
            $table->string('respondent')->nullable();
            $table->string('ecb_status')->nullable();
            $table->string('viol_date')->nullable();
            $table->string('infraction_codes')->nullable();
            $table->string('ecb_penalty_due')->nullable();
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
        Schema::dropIfExists('bis_ecb_violations');
    }
}
