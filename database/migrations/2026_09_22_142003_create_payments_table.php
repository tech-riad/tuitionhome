<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('invoice_id')->unique();
            $table->string('transaction_id')->nullable()->index();

            $table->decimal('amount', 12, 2);
            $table->string('currency', 10)->default('BDT');

            $table->string('payment_method')->nullable();

            $table->enum('status', [
                'pending',
                'processing',
                'success',
                'failed',
                'cancelled'
            ])->default('pending');

            $table->string('eps_transaction_id')->nullable()->index();

            $table->text('request_data')->nullable();
            $table->text('response_data')->nullable();

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
