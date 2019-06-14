<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBISDirective14ApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b_i_s_directive14_applicants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bis_job_application_id');
            $table->boolean('d14appInfo')->default(false);
            $table->text('name')->nullable();
            $table->text('business_name')->nullable();
            $table->text('business_phone')->nullable();
            $table->text('business_address')->nullable();
            $table->text('business_email')->nullable();
            $table->text('mobile_phone')->nullable();
            $table->text('applicant_type')->nullable();
            $table->text('license_number')->nullable();
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
        Schema::dropIfExists('b_i_s_directive14_applicants');
    }
}
