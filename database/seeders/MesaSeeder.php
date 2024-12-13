<?php

namespace Database\Seeders;

use App\Models\Mesa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 15) as $numero) {
            Mesa::create([
                'numero' => $numero,
            ]);
        }
    }
}
