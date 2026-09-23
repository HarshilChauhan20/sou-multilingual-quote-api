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
        Schema::table('users', function (Blueprint $table) {
            // Add quotes_id column
            $table->unsignedBigInteger('quotes_id')->nullable()->after('selected_language');
            
            // Add foreign key constraint
            $table->foreign('quotes_id')->references('id')->on('quotes')->onDelete('set null');
            
            // Drop the old quote_text column
            $table->dropColumn('quote_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key
            $table->dropForeign(['quotes_id']);
            
            // Drop quotes_id column
            $table->dropColumn('quotes_id');
            
            // Add back quote_text column
            $table->longText('quote_text')->nullable();
        });
    }
};
