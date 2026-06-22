<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutors', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->nullable();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password');
            $table->integer('role_id');
            $table->string('gender');
            $table->string('ip_address')->nullable();
            $table->timestamp('login_at')->nullable();
            $table->timestamp('phone_varified_at')->nullable();
            $table->timestamp('email_varified_at')->nullable();
            $table->string('otp')->nullable();
            $table->timestamp('otp_expiry')->nullable();
            $table->timestamp('premium_date')->nullable();
            $table->timestamp('featured_date')->nullable();
            $table->timestamp('verify_date')->nullable();
            $table->tinyInteger('phone_change_count')->nullable();
            $table->string('email_otp')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_verified')->default(0);
            $table->tinyInteger('is_featured')->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_sms')->default(1);
            $table->string('available_form')->nullable();
            $table->string('available_to')->nullable();
            $table->integer('premium_by')->nullable();
            $table->integer('verified_by')->nullable();
            $table->text('condition_note')->nullable();
            // $table->tinyInteger('is_premium')->default(0);
            // $table->string('deleted_by')->nullable();

            $table->string('user_agent')->nullable();
            $table->string('deactivate_by_admin')->nullable();
            $table->string('deactivate_by_tutor')->nullable();
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
        Schema::dropIfExists('tutors');
    }
}
