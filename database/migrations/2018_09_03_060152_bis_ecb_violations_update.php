<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BisEcbViolationsUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('bis_ecb_violations', function(Blueprint $table){ 
            $table->renameColumn('ecb_number', 'ecb_violation_number'); 
            $table->dropColumn('uri'); 
            $table->longText('url')->nullable(); 
            $table->renameColumn('bvs_status', 'buildings_violation_status'); 
            $table->longText('buildings_violation_status_msg')->nullable(); 
            $table->renameColumn('ecb_status', 'ecb_hearing_status');
            $table->renameColumn('viol_date', 'violation_date');
            $table->string('severity')->nullable(); 
            $table->string('respondent_name')->nullable();
            $table->renameColumn('mailing_address', 'respondent_mailing_address'); 
            $table->string('device_type')->nullable();
            $table->string('device_number')->nullable();
            $table->longText('section_of_law')->nullable();
            $table->longText('standard_description')->nullable();
            $table->longText('specific_violation_conditions')->nullable(); 
            $table->dropColumn('remedy'); 
            $table->renameColumn('issued_as_aggr_level', 'issued_as_aggravated_level');
            $table->dropColumn('cert_submission_date');
            $table->string('scheduled_hearing_time')->nullable();
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
    }
}
