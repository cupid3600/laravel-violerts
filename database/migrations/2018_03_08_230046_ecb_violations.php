<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EcbViolations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
        
    public function up () 
    { 
        Schema::create('ecb_violations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id')->nullable();
            $table->string('isn_dob_bis_extract')->nullable();
            $table->string('ecb_violation_number')->nullable();
            $table->string('ecb_violation_status')->nullable();
            $table->string('ecb_dob_violation_number')->nullable(); 
            $table->string('bin')->nullable(); 
            $table->string('boro')->nullable();
            $table->string('block')->nullable(); 
            $table->string('lot')->nullable(); 
            $table->string('hearing_date')->nullable();
            $table->string('hearing_time')->nullable();
            $table->string('served_date')->nullable();
            $table->string('issue_date')->nullable();
            $table->string('severity')->nullable();
            $table->string('violation_type')->nullable();
            $table->string('respondent_name')->nullable();
            $table->string('respondent_house_number')->nullable();
            $table->string('respondent_street')->nullable();
            $table->string('respondent_city')->nullable();
            $table->string('respondent_zip')->nullable();
            $table->longText('violation_description')->nullable();
            $table->string('penality_imposed')->nullable();
            $table->string('amount_paid')->nullable();
            $table->string('balance_due')->nullable();
            $table->string('infraction_code1')->nullable();
            $table->string('section_law_description1')->nullable();
            $table->string('infraction_code2')->nullable();
            $table->string('section_law_description2')->nullable();
            $table->string('infraction_code3')->nullable();
            $table->string('section_law_description3')->nullable();
            $table->string('infraction_code4')->nullable();
            $table->string('section_law_description4')->nullable();
            $table->string('infraction_code5')->nullable();
            $table->string('section_law_description5')->nullable();
            $table->string('infraction_code6')->nullable();
            $table->string('section_law_description6')->nullable();
            $table->string('infraction_code7')->nullable();
            $table->string('section_law_description7')->nullable();
            $table->string('infraction_code8')->nullable();
            $table->string('section_law_description8')->nullable();
            $table->string('infraction_code9')->nullable();
            $table->string('section_law_description9')->nullable();
            $table->string('infraction_code10')->nullable();
            $table->string('section_law_description10')->nullable();
            $table->string('aggravated_level')->nullable();
            $table->string('hearing_status')->nullable();
            $table->string('certification_status')->nullable();
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
        Schema::dropIfExists('ecb_violations');
    }
}
