<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBISBoilersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bis_boilers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id');
            $table->string('viol')->nullable();
            $table->string('num')->nullable();
            $table->string('uri')->nullable();
            $table->string('md')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('status')->nullable();
            $table->string('last_insp_date')->nullable();
            $table->string('last_recv_date')->nullable();
            $table->string('name')->nullable();
            $table->string('boiler_no')->nullable();
            $table->string('type')->nullable();
            $table->string('review_required')->nullable();
            $table->string('filed_at')->nullable();
            $table->string('bin')->nullable();
            $table->string('bbl')->nullable();
            $table->string('located_in')->nullable();
            $table->string('make_of_boiler')->nullable();
            $table->string('year')->nullable();
            $table->string('over6')->nullable();
            $table->string('no_of_boilers')->nullable();
            $table->string('fee')->nullable();
            $table->string('school')->nullable();
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
        Schema::dropIfExists('bis_boilers');
    }
}
