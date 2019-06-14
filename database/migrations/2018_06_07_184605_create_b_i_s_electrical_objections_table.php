<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBISElectricalObjectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b_i_s_electrical_objections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id');
            $table->integer('bis_electrical_id');
            $table->string('objection_id')->nullable();
            $table->string('objection_code')->nullable();
            $table->string('objection_description_comments')->nullable();
            $table->string('stat')->nullable();
            $table->string('first')->nullable();
            $table->string('latest')->nullable();
            $table->string('reslvd')->nullable();
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
        Schema::dropIfExists('b_i_s_electrical_objections');
    }
}
