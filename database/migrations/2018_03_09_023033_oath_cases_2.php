<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OathCases2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('oath_cases_2', function (Blueprint $table) { 
            $table->increments('id'); 
            $table->integer('oath_case_id')->nullable();
            $table->string('charge_1_code')->nullable();
            $table->string('charge_1_code_section')->nullable();
            $table->string('charge_1_code_description')->nullable();
            $table->string('charge_1_infraction_amount')->nullable();
            $table->string('charge_2_code')->nullable();
            $table->string('charge_2_code_section')->nullable();
            $table->string('charge_2_code_description')->nullable();
            $table->string('charge_2_infraction_amount')->nullable();
            $table->string('charge_3_code')->nullable();
            $table->string('charge_3_code_section')->nullable();
            $table->string('charge_3_code_description')->nullable();
            $table->string('charge_3_infraction_amount')->nullable();
            $table->string('charge_4_code')->nullable();
            $table->string('charge_4_code_section')->nullable();
            $table->string('charge_4_code_description')->nullable();
            $table->string('charge_4_infraction_amount')->nullable();
            $table->string('charge_5_code')->nullable();
            $table->string('charge_5_code_section')->nullable();
            $table->string('charge_5_code_description')->nullable();
            $table->string('charge_5_infraction_amount')->nullable();
            $table->string('charge_6_code')->nullable();
            $table->string('charge_6_code_section')->nullable();
            $table->string('charge_6_code_description')->nullable();
            $table->string('charge_6_infraction_amount')->nullable();
            $table->string('charge_7_code')->nullable();
            $table->string('charge_7_code_section')->nullable();
            $table->string('charge_7_code_description')->nullable();
            $table->string('charge_7_infraction_amount')->nullable();
            $table->string('charge_8_code')->nullable();
            $table->string('charge_8_code_section')->nullable();
            $table->string('charge_8_code_description')->nullable();
            $table->string('charge_8_infraction_amount')->nullable();
            $table->string('charge_9_code')->nullable();
            $table->string('charge_9_code_section')->nullable();
            $table->string('charge_9_code_description')->nullable();
            $table->string('charge_9_infraction_amount')->nullable();
            $table->string('charge_10_code')->nullable();
            $table->string('charge_10_code_section')->nullable();
            $table->string('charge_10_code_description')->nullable();
            $table->string('charge_10_infraction_amount')->nullable();
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
        Schema::dropIfExists('oath_cases_2');
    }
}
