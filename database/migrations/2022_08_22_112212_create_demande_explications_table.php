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
        Schema::create('demande_explications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('initiateur');
            $table->unsignedBigInteger('destinataire');
            $table->unsignedBigInteger('entity_id');
            $table->string('motif_id');
            $table->text('description');
            $table->string('reponse')->nullable();
            $table->string('sent_file_path')->default('de.pdf');
            $table->boolean('status')->default(false);
            $table->string('numero_demande_explication')->nullable();
            $table->string('answered_file_path')->nullable();
            $table->timestamp('date_incident')->nullable();
            $table->timestamp('date_decharge')->nullable();
            $table->timestamp('date_reponse')->nullable();
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
        Schema::dropIfExists('demande_explications');
    }
};
