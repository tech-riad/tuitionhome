<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoiceAndPaymentStatusToTutorConsultationRequests extends Migration
{
    public function up()
    {
        Schema::table('tutor_consultation_requests', function (Blueprint $table) {
            $table->foreignId('invoice_id')
                ->nullable()
                ->unique()
                ->constrained('invoices')
                ->nullOnDelete();
            $table->string('payment_status', 20)->default('unpaid');
        });
    }

    public function down()
    {
        Schema::table('tutor_consultation_requests', function (Blueprint $table) {
            $table->dropForeign(['invoice_id']);
            $table->dropUnique(['invoice_id']);
            $table->dropColumn(['invoice_id', 'payment_status']);
        });
    }
}
