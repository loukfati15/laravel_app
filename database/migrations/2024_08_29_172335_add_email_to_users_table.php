<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Check and drop the existing unique index on n_telephone if it exists
            if (Schema::hasColumn('users', 'n_telephone') && Schema::hasIndex('users', 'users_email_unique')) {
                $table->dropUnique('users_email_unique');
            }

            // Ensure the email column has a unique index
            if (Schema::hasColumn('users', 'email') && !Schema::hasIndex('users', 'users_email_unique')) {
                $table->unique('email', 'users_email_unique');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the unique index on email if it exists
            if (Schema::hasColumn('users', 'email') && Schema::hasIndex('users', 'users_email_unique')) {
                $table->dropUnique('users_email_unique');
            }

            // Optionally recreate the unique index on n_telephone if needed
            if (Schema::hasColumn('users', 'n_telephone') && !Schema::hasIndex('users', 'users_email_unique')) {
                $table->unique('n_telephone', 'users_email_unique');
            }
        });
    }
};
