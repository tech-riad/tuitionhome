<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceNotesTable extends Migration
{
    public function up()
    {
        Schema::create('invoice_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('note');
            $table->timestamps();

            $table->index(['invoice_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoice_notes');
    }
}
