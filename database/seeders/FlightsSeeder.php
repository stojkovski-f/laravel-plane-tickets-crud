<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Flight;

class FlightsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Flight::create([
            'flight_name'=> 'SX2',
            'source_airport' => 'Stockholm',
            'destination_airport' => 'Berlin',
            'price' => '200',
            'departure_time' => now()->addDays(7),
            'arrival_time' => now()->addDays(7)->addHours(2),
        ]);
    
        Flight::create([
            'flight_name'=> 'UZ7',
            'source_airport' => 'New York',
            'destination_airport' => 'Monaco',
            'price' => '300',
            'departure_time' => now()->addDays(14),
            'arrival_time' => now()->addDays(14)->addHours(8),
        ]);
    
        Flight::create([
            'flight_name'=> 'MM0',
            'source_airport' => 'Zurich',
            'destination_airport' => 'Paris',
            'price' => '100',
            'departure_time' => now()->addDays(21),
            'arrival_time' => now()->addDays(21)->addHours(1),
        ]);
    }
}
