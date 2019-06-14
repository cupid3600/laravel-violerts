<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BisDobViolations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bis_dob_violations', function (Blueprint $table) { 
            $table->increments('id'); 
            $table->integer('property_id')->nullable();
            $table->string('number')->nullable();
            $table->string('uri')->nullable();
            $table->string('issue_date')->nullable();
            $table->string('type')->nullable();
            $table->boolean('active')->default(false);
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
        Schema::dropIfExists('bis_dob_violations');
    }
}
