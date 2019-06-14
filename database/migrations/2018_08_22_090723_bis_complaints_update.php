<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BisComplaintsUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('bis_complaints', function (Blueprint $table) { 
            // 
            $table->renameColumn('uri', 'url')->nullable();
            $table->string('badge_number')->nullable();
            $table->string('permit_number')->nullable();
            $table->string('electrical_violation_number')->nullable();
            $table->string('category_code')->nullable();
            $table->string('category_code_description')->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('received')->nullable();
            $table->string('owner')->nullable();
            $table->string('too_reference_number')->nullable();
            $table->string('prev_ecb_violation_number')->nullable();
            $table->string('prev_dob_violation_number')->nullable();
            $table->integer('property_id')->nullable()->change();
            $table->string('disposition_date')->nullable(); 
            $table->string('disposition_description')->nullable();
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
