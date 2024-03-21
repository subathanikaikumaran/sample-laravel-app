<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'suba',
            'email' => 'suba@ins.lk',
            'role'=>'instructor'
        ]); 

        User::factory()->create([
            'name' => 'Amma',
            'email' => 'admin@admin.lk',
            'role'=>'admin'
        ]);

        User::factory()->create([
            'name' => 'Kiri',
            'email' => 'kiri@member.lk',
            'role'=>'member'
        ]);
       User::factory()->count(10)->create(); 
       User::factory()->count(10)->create(['role'=>'instructor']); 
    }
}
