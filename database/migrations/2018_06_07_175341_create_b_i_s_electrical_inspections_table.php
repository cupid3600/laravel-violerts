<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBISElectricalInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b_i_s_electrical_inspections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id');
            $table->integer('bis_electrical_id');
            $table->string('insp_id')->nullable();
            $table->string('field_date')->nullable();
            $table->string('disp_date')->nullable();
            $table->string('fld_disp')->nullable();
            $table->string('obj_disp')->nullable();
            $table->string('enrg_rec')->nullable();
            $table->string('time_insp')->nullable();
            $table->string('reinsp_date')->nullable();
            $table->string('new_obj')->nullable();
            $table->string('appt_flag')->nullable();
            $table->string('inspection_comments')->nullable();
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
        Schema::dropIfExists('b_i_s_electrical_inspections');
    }
}
