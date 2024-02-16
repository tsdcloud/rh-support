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
        Schema::create('proposition_sanctions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposition_sanction');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('demande_explication_id');
            $table->unsignedBigInteger('sanction_id')->nullable();
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
        Schema::dropIfExists('proposition_sanctions');
    }
};
