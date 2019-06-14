<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BisComplaints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bis_complaints', function (Blueprint $table) { 
            $table->increments('id'); 
            $table->integer('property_id'); 
            $table->string('complaint_number')->nullable();
            $table->string('uri')->nullable();
            $table->string('address')->nullable();
            $table->string('date_entered')->nullable();
            $table->string('category')->nullable();
            $table->string('inspection_date')->nullable();
            $table->string('disposition')->nullable();
            $table->string('status')->nullable();
            $table->string('comments')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('active')->default(0);
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
        Schema::dropIfExists('bis_complaints');
    }
}
