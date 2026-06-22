<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parents_id')->constrained('parents')->cascadeOnDelete();
            $table->text('body');
            $table->string('created_by')->nullable();
            $table->string('emp_id')->nullable();
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
        Schema::dropIfExists('parent_notes');
    }
}
