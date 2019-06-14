<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationUpdate4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('b_i_s_illuminated_signs', function (Blueprint $table) { 
            $table->string('uri')->nullable();
            $table->string('job_number')->nullable();
            $table->string('job_number_uri')->nullable();
            $table->string('seq_no')->nullable();
        });

        Schema::table('bis_permits', function (Blueprint $table) { 
            $table->renameColumn('history', 'history_uri');
            $table->string('permit_uri')->nullable();
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
