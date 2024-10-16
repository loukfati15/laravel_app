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
            $table->id('user_id'); // Primary Key
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('n_telephone')->unique();
            $table->string('address')->nullable();
            $table->integer('nb_gwt')->default(0);
            $table->integer('nb_ruches')->default(0);
            $table->boolean('enable')->default(1); // 1 for enabled, 0 for disabled
            $table->string('user_type')->nullable();
            $table->unsignedBigInteger('main_user')->nullable(); // Foreign key to another user
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
        Schema::dropIfExists('users');
    }
}
