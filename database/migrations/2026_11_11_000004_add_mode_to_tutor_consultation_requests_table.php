<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModeToTutorConsultationRequestsTable extends Migration
{
    public function up()
    {
        Schema::table('tutor_consultation_requests', function (Blueprint $table) {
            $table->string('mode', 10)->nullable()->after('preferred_date');
        });
    }

    public function down()
    {
        Schema::table('tutor_consultation_requests', function (Blueprint $table) {
            $table->dropColumn('mode');
        });
    }
}
