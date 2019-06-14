<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AcrisPpls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('acris_ppls', function (Blueprint $table) { 
            $table->increments('id'); 
            $table->integer('property_id')->nullable();
            $table->string('document_id')->nullable(); 
            $table->string('record_type')->nullable();
            $table->string('borough')->nullable(); 
            $table->string('block')->nullable();
            $table->string('lot')->nullable();
            $table->string('easement')->nullable();
            $table->string('partial_lot')->nullable();
            $table->string('air_rights')->nullable();
            $table->string('subterranean_rights')->nullable();
            $table->string('property_type')->nullable();
            $table->string('street_number')->nullable();
            $table->string('street_name')->nullable();
            $table->string('addr_unit')->nullable();
            $table->string('good_through_date')->nullable();
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
        //
        Schema::dropIfExists('acris_ppls');
    }
}
