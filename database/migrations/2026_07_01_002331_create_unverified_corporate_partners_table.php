<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnverifiedCorporatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unverified_corporate_partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->string('password');
            $table->string('role_id')->default('3');
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('otp_expiry')->nullable();
            $table->timestamp('last_otp_resend')->nullable();
            $table->string('otp')->nullable();
            $table->integer('otp_resend_count')->default(0);
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
        Schema::dropIfExists('unverified_corporate_partners');
    }
}
