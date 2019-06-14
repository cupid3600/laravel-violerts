<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationUpdate5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('portfolios', function (Blueprint $table) { 
            $table->integer('airtable_key_id')->nullable();
        });

        Schema::table('bis_ecb_violations', function (Blueprint $table) { 
            $table->text('remedy')->nullable()->change();
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
