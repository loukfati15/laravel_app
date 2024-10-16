<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users',function(Blueprint $table){
            $table->renameColumn('id', 'user_id');
            $table->renameColumn('email', 'n_telephone');

            // Add new columns
            $table->string('address')->nullable();
            $table->integer('nb_gwt')->default(0);
            $table->integer('nb_ruches')->default(0);
            $table->boolean('enable')->default(true);
            $table->string('user_type')->nullable();
            $table->unsignedBigInteger('main_user')->nullable();

            // Drop columns if needed
            $table->dropColumn('email_verified_at');
            $table->dropColumn('remember_token');
        });
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::table('users',function(Blueprint $table){
            $table->renameColumn('user_id', 'id');
            $table->renameColumn('n_telephone', 'email');

            $table->dropColumn(['address', 'nb_gwt', 'nb_ruches', 'enable', 'user_type', 'main_user']);

            $table->timestamp('email_verified_at')->nullable();
            $table->string('remember_token', 100)->nullable();
        });
    }
};
