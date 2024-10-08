<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ticket;

class TicketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ticket::create([
            'passenger_name'=> 'Filip Stojkovski',
            'flight_id' => '1',
            'passport' => '23423443',
            'seat' => '11A',
        ]);
    }
}
