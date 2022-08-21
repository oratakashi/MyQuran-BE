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
        Schema::create('surah', function (Blueprint $table) {
            $table->integer("id")->primary();
            $table->string("nama");
            $table->string("rukuk");
            $table->string("urut");
            $table->text("keterangan");
            $table->string("arti");
            $table->string("asma");
            $table->string("audio");
            $table->string("type");
            $table->integer("ayat");
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
        Schema::dropIfExists('surah');
    }
};
