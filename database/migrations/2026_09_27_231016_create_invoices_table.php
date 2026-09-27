<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreign('tutor_id')->references('id')->on('tutors');
            $table->unsignedBigInteger('tutor_id');
            $table->string('invoice_number')->unique();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 10)->default('BDT');
            $table->enum('status', [
                'pending',
                'paid',
                'cancelled'
            ])->default('pending');
            $table->timestamp('issued_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->string('tutor_email')->nullable();
            $table->string('tutor_name')->nullable();
            $table->string('tutor_phone')->nullable();
            $table->string('unique_id')->nullable();
            $table->string('job_id')->nullable();
            $table->string('payment_date')->nullable();
            $table->unsignedBigInteger('issued_by')->nullable();


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
        Schema::dropIfExists('invoices');
    }
}
