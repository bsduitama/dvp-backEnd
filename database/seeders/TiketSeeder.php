<?php

namespace Database\Seeders;

use App\Models\Tiket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class TiketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $tikets = Tiket::factory()->count(10)
                                  ->state(new Sequence(
                                    ['status' => 'open'],
                                    ['status' => 'close']
                                  ))
                                  ->create();

    }
}
