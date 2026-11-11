<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddParentSupportToConsultationRequestsAndInvoices extends Migration
{
    public function up()
    {
        Schema::table('tutor_consultation_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('tutor_id')->nullable()->change();
            $table->foreignId('parent_id')->nullable()->after('tutor_id')->constrained('parents')->cascadeOnDelete();
            $table->index(['parent_id', 'created_at']);
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('tutor_id')->nullable()->change();
            $table->foreignId('parent_id')->nullable()->after('tutor_id')->constrained('parents')->nullOnDelete();
        });
    }

    public function down()
    {
        if (
            DB::table('tutor_consultation_requests')->whereNotNull('parent_id')->exists()
            || DB::table('invoices')->whereNotNull('parent_id')->exists()
        ) {
            throw new RuntimeException('Cannot remove parent consultation support while parent requests or invoices exist.');
        }

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
            $table->unsignedBigInteger('tutor_id')->nullable(false)->change();
        });

        Schema::table('tutor_consultation_requests', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropIndex(['parent_id', 'created_at']);
            $table->dropColumn('parent_id');
            $table->unsignedBigInteger('tutor_id')->nullable(false)->change();
        });
    }
}
