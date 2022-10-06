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
        Schema::create('ayat_indopak', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->text("arabic");
            $table->timestamps();
            $table->foreign("id")
                ->references("id")
                ->on("ayat")
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ayat_indopak');
    }
};
