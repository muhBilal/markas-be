<?php

namespace Database\Seeders;

use App\Models\EventRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EventRole::create([
            'role' => 'Hacker'
        ]);
        EventRole::create([
            'role' => 'Hipster'
        ]);
        EventRole::create([
            'role' => 'Hustler'
        ]);
    }
}
