<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorporateAgentsTable extends Migration
{
    public function up()
    {
        Schema::create('corporate_agents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->string('phone')->unique();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('password')->nullable();
            $table->string('unique_id')->nullable();
            $table->string('image')->nullable();
            $table->string('role_id')->default('4');
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('otp_expiry')->nullable();
            $table->string('email_otp')->nullable();
            $table->timestamp('is_verified')->nullable();
            $table->string('otp')->nullable();
            $table->enum('is_active', ['0', '1'])->default('1');
            $table->enum('is_sms', ['0', '1'])->default('1');
            $table->string('balances')->nullable();
            $table->integer('otp_resend_count')->default(0);
            $table->timestamp('last_otp_resend')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('corporate_agents');
    }
}
