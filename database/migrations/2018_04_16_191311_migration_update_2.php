
<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationUpdate2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function(Blueprint $table) { 
            $table->boolean('isSuspended')->default(false);
            $table->string('profile_id')->nullable();
            $table->string('user_group')->default(1);
            $table->string('mobile_phone')->nullable();
        });

        Schema::table('portfolios', function(Blueprint $table) { 
            $table->string('airtable_base_id')->nullable();
            $table->boolean('init_summary')->default(false);
            $table->boolean('email_alerts_enabled')->default(false);
            $table->boolean('sms_alerts_enabled')->default(false);
            $table->boolean('airtable_enabled')->default(false);
        });

        Schema::table('bis_ecb_violations', function(Blueprint $table) { 
            $table->boolean('active')->nullable();
        });

        Schema::table('bis_job_applications', function(Blueprint $table) { 
            $table->boolean('active')->nullable(); 
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
