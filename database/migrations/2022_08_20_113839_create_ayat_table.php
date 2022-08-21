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
        Schema::create('ayat', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->text("arabic");
            $table->text("translation");
            $table->integer("nomor");
            $table->text("latin");
            $table->integer("idSurah")->index("idSurah");
            $table->timestamps();
            $table->foreign("idSurah")->references("id")->on("surah");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ayat');
    }
};
