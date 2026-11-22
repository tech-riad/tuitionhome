<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorImportsTable extends Migration
{
    public function up()
    {
        Schema::create('tutor_imports', function (Blueprint $table) {
            $table->id();
            $table->string('storage_path');
            $table->text('original_filename');
            $table->string('status', 20)->default('pending');
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->unsignedInteger('inserted')->default(0);
            $table->unsignedInteger('skipped')->default(0);
            $table->unsignedInteger('duplicate_phone')->default(0);
            $table->unsignedInteger('duplicate_email')->default(0);
            $table->unsignedInteger('invalid_phone')->default(0);
            $table->unsignedInteger('row_errors')->default(0);
            $table->text('error_message')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tutor_imports');
    }
}
