<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBISFacadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bis_facades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id');
            $table->string('cycle');
            $table->string('sub_cycle');
            $table->string('control_number');
            $table->string('control_number_uri');
            $table->string('filed_at');
            $table->string('seq_no');
            $table->string('submitted_on')->nullable();
            $table->string('current_status');
            $table->string('applicant_name')->nullable();
            $table->string('nys_license_number')->nullable();
            $table->string('applicant_business')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('owner_business')->nullable();
            $table->string('exterior_wall_types')->nullable();
            $table->string('late_filing');
            $table->string('late_filing_amount');
            $table->string('late_filing_fee_paid');
            $table->string('failure_to_file');
            $table->string('failure_to_file_amount');
            $table->string('failure_to_file_fee_paid');
            $table->string('failure_to_correct');
            $table->string('failure_to_correct_amount');
            $table->string('failure_to_correct_fee_paid');
            $table->string('initial_filing_date');
            $table->string('initial_filing_status');
            $table->string('amended_filing_date')->nullable();
            $table->string('amended_filing_status')->nullable();
            $table->string('subsequent_filing_date')->nullable();
            $table->string('subsequent_filing_status')->nullable();
            $table->string('prior_cycle_filing_date')->nullable();
            $table->string('prior_status')->nullable();
            $table->string('field_inspection_completed_date')->nullable();
            $table->string('qewi_signed_date')->nullable();
            $table->string('house_number');
            $table->string('street_name');
            $table->string('bbl_seqno');
            $table->string('bin');
            $table->string('num_stories');
            $table->string('init_file_date');
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
        Schema::dropIfExists('bis_facades');
    }
}
