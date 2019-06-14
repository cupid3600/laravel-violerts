<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBISIlluminatedSignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b_i_s_illuminated_signs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id');
            $table->string('added_on')->nullable();
            $table->string('last_modified')->nullable();
            $table->string('address')->nullable();
            $table->string('zip')->nullable();
            $table->string('bbl_seqno')->nullable();
            $table->string('sign_wording')->nullable();
            $table->string('illumination')->nullable();
            $table->string('square_footage')->nullable();
            $table->string('amount_due')->nullable();
            $table->string('bin')->nullable();
            $table->string('last_billed_on')->nullable();
            $table->string('last_bill_amount')->nullable();
            $table->string('billing_code')->nullable();
            $table->string('last_permit_issued')->nullable();
            $table->string('permit_code')->nullable();
            $table->string('annual_permit_number')->nullable();
            $table->string('expires')->nullable();
            $table->string('comment')->nullable();
            $table->string('owner_last_name')->nullable();
            $table->string('owner_first_name')->nullable();
            $table->string('owner_business')->nullable();
            $table->string('owner_address')->nullable();
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
        Schema::dropIfExists('b_i_s_illuminated_signs');
    }
}
