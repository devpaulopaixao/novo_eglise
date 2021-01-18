<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfiguracaoIgrejasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracao_igrejas', function (Blueprint $table) {
            $table->id();

            $table->string('url')->nullable();
            $table->string('youtube')->nullable();
            $table->string('twitter')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('whatsapp')->nullable();

            $table->unsignedBigInteger('igreja_id')->nullable();
            $table->foreign('igreja_id')->references('id')->on('igrejas')->onDelete("cascade");

            $table->unsignedBigInteger('template_id')->default(1);
            $table->foreign('template_id')->references('id')->on('templates');

            $table->timestamps();
        });

        DB::statement("ALTER TABLE configuracao_igrejas ADD logotipo MEDIUMBLOB");
        DB::statement("ALTER TABLE configuracao_igrejas ADD favicon MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configuracao_igrejas');
    }
}
