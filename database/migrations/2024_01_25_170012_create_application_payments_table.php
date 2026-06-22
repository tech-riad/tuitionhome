<?php
use App\Models\JobOffer;
use App\Models\Tutor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Tutor::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(JobOffer::class)->constrained()->cascadeOnDelete();
            $table->foreignId('application_id')->constrained('job_applications')->cascadeOnDelete();
            $table->timestamp('due_payment_date')->nullable();
            $table->integer('due_amount')->nullable();
            $table->integer('received_amount')->nullable();
            $table->text('received_number')->nullable();
            $table->string('payment_method')->nullable();

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
        Schema::dropIfExists('application_payments');
    }
}
