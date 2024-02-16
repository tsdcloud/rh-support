<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('piece_jointe_proposition_sanctions', function (Blueprint $table) {
            $table->id();

            $table->string('uuid')->default((string) Uuid::uuid4());
            $table->string('piece_jointe');
            $table->unsignedBigInteger('proposition_sanction_id');

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
        Schema::dropIfExists('piece_jointe_proposition_sanctions');
    }
};
