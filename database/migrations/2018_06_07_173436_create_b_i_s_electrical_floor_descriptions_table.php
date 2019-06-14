<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBISElectricalFloorDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b_i_s_electrical_floor_descriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id');
            $table->integer('bis_electrical_id');
            $table->string('floor')->nullable();
            $table->string('apt')->nullable();
            $table->string('fixt')->nullable();
            $table->string('att')->nullable();
            $table->string('ac')->nullable();
            $table->string('switch')->nullable();
            $table->string('num_fixtures')->nullable();
            $table->string('motors_generators_num')->nullable();
            $table->string('motors_generators_total_hp_kw')->nullable();
            $table->string('heaters_num')->nullable();
            $table->string('heaters_total_kw')->nullable();
            $table->string('transformers_num')->nullable();
            $table->string('transformers_total_kva')->nullable();
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
        Schema::dropIfExists('b_i_s_electrical_floor_descriptions');
    }
}
