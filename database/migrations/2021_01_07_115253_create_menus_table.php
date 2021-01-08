<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('igreja_id');
            $table->foreign('igreja_id')->references('id')->on('igrejas');

            $table->unsignedBigInteger('menu_id')->nullable();
            $table->foreign('menu_id')->references('id')->on('menus');

            //$table->integer('nivel')->default(1);
            $table->integer('ordem')->default(1);
            $table->string('titulo');
            $table->string('url')->nullable();
            $table->string('target')->nullable()->comment('_blank|_self|_parent|_top|framename');
            $table->string('frame_id')->nullable();

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
        Schema::dropIfExists('menus');
    }
}
