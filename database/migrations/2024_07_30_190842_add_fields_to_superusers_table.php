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
        Schema::table('superusers', function (Blueprint $table) {
            $table->dateTime('date')->nullable();
            $table->string('user_id', 100)->nullable();
            $table->string('N_telephone', 20)->nullable();
            $table->json('region_number')->nullable();
            $table->string('poste', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('superusers', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->dropColumn('user_id');
            $table->dropColumn('N_telephone');
            $table->dropColumn('region_number');
            $table->dropColumn('poste');
        });
    }
};
