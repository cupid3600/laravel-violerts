<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBISActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b_i_s_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id');
            $table->text('number')->nullable();
            $table->text('number_uri')->nullable();
            $table->text('type')->nullable();
            $table->text('file_date')->nullable();
            $table->text('pdf_page_uri')->nullable();
            $table->text('lno_use')->nullable();
            $table->text('lno_floor')->nullable();
            $table->text('comments')->nullable();
            $table->text('dismissal_date')->nullable();
            $table->text('closure_date')->nullable();
            $table->text('agency_license')->nullable();
            $table->text('badge_number')->nullable();
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
        Schema::dropIfExists('b_i_s_actions');
    }
}
