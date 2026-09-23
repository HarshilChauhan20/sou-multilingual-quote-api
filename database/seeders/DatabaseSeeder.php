<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database with test users and quotes.
     */
    public function run(): void
    {
        // Create sample users for testing
        User::factory(10)->create();

        // Create a specific test user
        User::factory()->create([
            'name' => 'John Doe',
            'age' => 28,
            'location' => 'New York',
            'selected_language' => 'English',
        ]);

        // Seed quotes in multiple languages
        $this->call(QuoteSeeder::class);
    }
}

