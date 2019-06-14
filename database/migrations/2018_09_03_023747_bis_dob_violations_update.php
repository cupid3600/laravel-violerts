<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BisDobViolationsUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('bis_dob_violations', function(Blueprint $table){ 
            $table->renameColumn('number', 'dob_violation_number'); 
            $table->dropColumn('uri'); 
            $table->longText('url')->nullable();
            $table->string('status')->nullable(); 
            $table->string('file_date')->nullable(); 
            $table->string('violation_type_code')->nullable(); 
            $table->string('violation_type')->nullable(); 
            $table->renameColumn('ecb_number', 'ecb_violation_number'); 
            $table->string('violation_category')->nullable(); 
            $table->renameColumn('inspector', 'disposition_inspector');
            $table->renameColumn('comments', 'disposition_comments');
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
