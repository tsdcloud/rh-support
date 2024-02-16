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
        Schema::create('reponse_supplementaire_des', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('demande_explication_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('initiateur');
            $table->text('description')->nullable();
            $table->text('reponse')->nullable();
            $table->datetime('date_reponse')->nullable();
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
        Schema::dropIfExists('reponse_supplementaire_des');
    }
};
