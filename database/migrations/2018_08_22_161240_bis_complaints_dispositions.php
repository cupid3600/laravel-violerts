<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BisComplaintsDispositions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bis_complaints_dispositions', function (Blueprint $table){ 
            $table->increments('id');
            $table->integer('property_id');
            $table->integer('bis_complaint_id');
            $table->string('disposition_id')->nullable();
            $table->string('disposition_date')->nullable();
            $table->string('code')->nullable();
            $table->string('disposition')->nullable();
            $table->string('inspection_by')->nullable();
            $table->string('inspection_date')->nullable();
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
        Schema::drop('bis_complaints_dispositions');
    }
}
