<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::factory(1)->createMany([
            ["name" => "Pegawai \"Biasa\""],
            ["name" => "Manager"],
            ["name" => "Direktur"],
            ["name" => "Operator"]
        ]);
    }
}
