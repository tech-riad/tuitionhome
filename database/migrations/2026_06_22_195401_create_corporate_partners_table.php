<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorporatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corporate_partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->string('password');
            $table->string('unique_id')->nullable();
            $table->string('image')->nullable();
            $table->string('role_id')->default('3');
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('otp_expiry')->nullable();
            $table->string('email_otp')->nullable();
            $table->timestamp('is_verified')->nullable();
            $table->string('otp')->nullable();
            $table->enum('is_active', ['0', '1'])->default('1');
            $table->enum('is_sms', ['0', '1'])->default('1');
            $table->string('balances')->nullable();
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
        Schema::dropIfExists('corporate_partners');
    }
}
