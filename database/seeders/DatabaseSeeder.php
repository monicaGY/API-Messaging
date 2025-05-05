<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'name' => 'Sebastian García',
             'email' => 'sebastian.garcia@example.com',
            'password' => bcrypt('sebastian123'),
         ]);
        \App\Models\User::factory()->create([
            'name' => 'Fernando Gómez',
            'email' => 'fernando.gomez@example.com',
            'password' => bcrypt('fernando123'),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Juana Gutierrez',
            'email' => 'juana.gutierrez@example.com',
            'password' => bcrypt('juana123'),

        ]);
        $this->call(ConversationsSeed::class);

    }
}
