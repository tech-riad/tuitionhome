<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtpResendInfoToTutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tutors', function (Blueprint $table) {
            $table->unsignedInteger('otp_resend_count')->default(0);
            $table->timestamp('last_otp_resend')->nullable();
        });
    }

    public function down()
    {
        Schema::table('tutors', function (Blueprint $table) {
            $table->dropColumn('otp_resend_count');
            $table->dropColumn('last_otp_resend');
        });
    }

}
