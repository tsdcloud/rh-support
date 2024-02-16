<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demande_explications', function (Blueprint $table) {
            // $table->dropColumn('file_note_decision_sanction');
            $table->string('file_note_decision_sanction')->nullable();
            $table->unsignedBigInteger('note_decision_sanction_submit_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demande_explications', function (Blueprint $table) {
            $table->dropColumn('file_note_decision_sanction');
            $table->dropColumn('note_decision_sanction_submit_by');
        });
    }
};
