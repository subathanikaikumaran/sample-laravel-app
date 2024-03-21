<?php

namespace Database\Seeders;

use App\Models\Petition;
use Database\Factories\PetitionFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PetitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Petition::factory()->count(50)->create(); 
    }
}
