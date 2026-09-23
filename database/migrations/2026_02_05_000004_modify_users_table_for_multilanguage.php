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
        // Modify the users table to add the new columns for multi-language registration
        Schema::table('users', function (Blueprint $table) {
            // Add new columns for multi-language registration
            $table->integer('age')->nullable();
            $table->string('location')->nullable();
            $table->string('selected_language')->default('English')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop new columns
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['age', 'location', 'selected_language']);
        });
    }
};
