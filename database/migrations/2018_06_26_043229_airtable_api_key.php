<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AirtableApiKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('airtable_api_key', function (Blueprint $table) { 
            $table->increments('id'); 
            $table->integer('user_id'); 
            $table->string('key')->unique(); 
            $table->string('name'); 
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
        Schema::dropIfExists('airtable_api_key');
    }
}
