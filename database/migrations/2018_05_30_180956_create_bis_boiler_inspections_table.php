<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBISBoilerInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bis_boiler_inspections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('boiler_number')->nullable();
            $table->integer('bis_boiler_id');
            $table->string('bin')->nullable();
            $table->string('inspection_date')->nullable();
            $table->string('rec_date')->nullable();
            $table->string('entry_date')->nullable();
            $table->string('name')->nullable();
            $table->string('int_ext')->nullable();
            $table->string('results')->nullable();
            $table->string('nys_certificate')->nullable();
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
        Schema::dropIfExists('bis_boiler_inspections');
    }
}
