<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Delete all quotes to remove duplicates
        DB::table('quotes')->truncate();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op - we can't restore deleted data
    }
};
