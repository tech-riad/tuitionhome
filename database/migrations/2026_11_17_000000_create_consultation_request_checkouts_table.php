<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationRequestCheckoutsTable extends Migration
{
    public function up()
    {
        Schema::create('consultation_request_checkouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->unique()->constrained('invoices')->cascadeOnDelete();
            $table->foreignId('tutor_id')->nullable()->constrained('tutors')->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('parents')->cascadeOnDelete();
            $table->text('message')->nullable();
            $table->string('mode', 10);
            $table->date('preferred_date');
            $table->timestamps();

            $table->index(['tutor_id', 'parent_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultation_request_checkouts');
    }
}
