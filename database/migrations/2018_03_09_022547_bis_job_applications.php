<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BisJobApplications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bis_job_applications', function (Blueprint $table) { 
            $table->increments('id'); 
            $table->integer('property_id')->nullable();
            $table->string('file_date')->nullable();
            $table->string('job_number')->nullable();
            $table->string('uri')->nullable();
            $table->string('doc_number')->nullable();
            $table->string('job_type')->nullable();
            $table->string('job_status')->nullable();
            $table->string('status_date')->nullable();
            $table->string('lic_number')->nullable();
            $table->string('applicant')->nullable();
            $table->string('in_audit')->nullable();
            $table->string('zoning_status')->nullable();
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
        Schema::dropIfExists('bis_job_applications');
    }
}
