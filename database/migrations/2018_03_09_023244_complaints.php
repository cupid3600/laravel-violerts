<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Complaints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('complaints', function (Blueprint $table) { 
            $table->increments('id'); 
            $table->integer('property_id')->nullable();
            $table->string('complaint_number')->nullable();
            $table->string('status')->nullable();
            $table->string('date_entered')->nullable();
            $table->string('house_number')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('house_street')->nullable();
            $table->string('bin')->nullable();
            $table->string('community_board')->nullable();
            $table->string('special_district')->nullable();
            $table->string('complaint_category')->nullable();
            $table->string('unit')->nullable();
            $table->string('disposition_date')->nullable();
            $table->string('disposition_code')->nullable();
            $table->string('inspection_date')->nullable();
            $table->string('dobrundate')->nullable();
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
        Schema::dropIfExists('complaints');
    }
}
