<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Properties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('house_number');
            $table->string('street_name');
            $table->integer('borough');
            $table->string('address')->nullable();
            $table->integer('bin');
            $table->integer('block');
            $table->integer('lot');
            $table->integer('source')->nullable();
            $table->string('coo_uri')->nullable(); 
            $table->string('cross_streets')->nullable();
            $table->string('complaints_uri')->nullable();
            $table->string('complaints_total')->nullable();
            $table->string('complaints_open')->nullable();
            $table->string('complaints_endpoint')->nullable();
            $table->string('dob_violations_uri')->nullable();
            $table->string('dob_violations_total')->nullable();
            $table->string('dob_violations_open')->nullable();
            $table->string('dob_violations_endpoint')->nullable();
            $table->string('ecb_violations_uri')->nullable();
            $table->string('ecb_violations_total')->nullable();
            $table->string('ecb_violations_open')->nullable();
            $table->string('ecb_violations_endpoint')->nullable();
            $table->longText('jobs_filings_uri')->nullable();
            $table->string('jobs_filings_total')->nullable();
            $table->longText('jobs_filings_endpoint')->nullable();
            $table->string('elevator_records_uri')->nullable();
            $table->string('electrical_applications_uri')->nullable();
            $table->string('permits_in_process_uri')->nullable();
            $table->string('illuminated_signs_permit_uri')->nullable();
            $table->string('plumbing_inspections_uri')->nullable();
            $table->string('open_plumbing_jobs_uri')->nullable();
            $table->string('facades_uri')->nullable();
            $table->string('marquee_permits_uri')->nullable();
            $table->string('boiler_records_uri')->nullable();
            $table->string('dep_boiler_information_uri')->nullable();
            $table->string('crane_information_uri')->nullable();
            $table->string('after_hours_permit_uri')->nullable();
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
        Schema::dropIfExists('properties');
    }
}
