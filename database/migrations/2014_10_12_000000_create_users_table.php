<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('cpf')->unique()->nullable();
            $table->string('rg')->nullable();
            $table->char('genre', 1)->nullable();
            $table->string('phone')->nullable();
            $table->string('cell')->nullable();
            $table->char('terms_accept', 1)->nullable();

            $table->string('password');

            $table->rememberToken();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE users ADD avatar_blob MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
