<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BisJApplicants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bis_j_applicants', function(Blueprint $table){ 
            $table->increments('id'); 
            $table->string('name')->nullable(); 
            $table->string('business_name')->nullable(); 
            $table->string('business_phone')->nullable();
            $table->string('business_address')->nullable();
            $table->string('business_fax')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('license_number')->nullable();
            $table->string('applicant_type')->nullable();
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
        Schema::dropIfExists('bis_j_applicants');
    }
}
