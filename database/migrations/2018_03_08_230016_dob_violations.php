<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DobViolations extends Migration
{
    public function up()
    {
        //
        Schema::create('dob_violations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id');
            $table->string('isn_dob_bis_viol')->nullable();
            $table->string('boro')->nullable();
            $table->string('bin')->nullable();
            $table->string('block')->nullable();
            $table->string('lot')->nullable();
            $table->string('issue_date')->nullable();
            $table->string('violation_type_code')->nullable();
            $table->string('violation_number')->nullable();
            $table->string('house_number')->nullable();
            $table->string('street')->nullable();
            $table->string('disposition_date')->nullable();
            $table->string('disposition_comments')->nullable();
            $table->string('device_number')->nullable();
            $table->longText('description')->nullable();
            $table->string('ecb_number')->nullable();
            $table->string('number')->nullable();
            $table->string('violation_category')->nullable();
            $table->string('violation_type')->nullable();
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
        Schema::dropIfExists('dob_violations');
    }
}
