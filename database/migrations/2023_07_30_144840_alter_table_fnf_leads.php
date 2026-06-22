<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableFnfLeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fnf_leads', function (Blueprint $table) {
            $table->string('email')->unique()->nullable();
            $table->string('location')->nullable()->change();
            $table->string('additional_phone')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fnf_leads', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('additional_phone');
        });
    }
}
