<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = ["VISIONARY", "EXTRAMILE", "STRATEGIC", "GRIT", "INTEGRITY", "FOCUSED", "AGILE", "PASSION", "RESOURCEFUL", "CREATIVE"];

        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag,
            ]);
        }
    }
}
