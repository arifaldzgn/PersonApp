<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MuscleGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('muscle_groups')->insert([
            ['name' => 'Chest'],
            ['name' => 'Back'],
            ['name' => 'Arms'],
            ['name' => 'Shoulders'],
            ['name' => 'Abs'],
            ['name' => 'Legs'],
        ]);

    }
}
