<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnverifiedCorporateAgentsTable extends Migration
{
    public function up()
    {
        Schema::create('unverified_corporate_agents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->string('phone')->unique();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('password')->nullable();
            $table->string('role_id')->default('3');
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('otp_expiry')->nullable();
            $table->timestamp('last_otp_resend')->nullable();
            $table->string('otp')->nullable();
            $table->integer('otp_resend_count')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('unverified_corporate_agents');
    }
}
