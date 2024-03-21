<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ClassType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
           UserSeeder::class,
           ClassTypeSeeder::class,
           ScheduledClassSeeder::class,
           AuthorSeeder::class,
           PetitionSeeder::class,
           CustomerSeeder::class
        ]);
    }
}
