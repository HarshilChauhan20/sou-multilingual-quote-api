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
        // Modify users table to remove auth-related columns
        Schema::table('users', function (Blueprint $table) {
            // Drop the unique index on email if it exists
            try {
                $table->dropUnique(['email']);
            } catch (\Exception $e) {
                // Index doesn't exist, continue
            }

            // Drop unnecessary columns
            $table->dropColumn(['email', 'password', 'email_verified_at', 'remember_token']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Restore columns
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
        });
    }
};
