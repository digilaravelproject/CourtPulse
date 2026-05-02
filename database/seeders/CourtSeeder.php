<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Court;

class CourtSeeder extends Seeder
{
    public function run(): void
    {
        $courts = [
            [
                'name' => 'Supreme Court of India',
                'type' => 'supreme',
                'city' => 'New Delhi',
                'state' => 'Delhi',
            ],
            [
                'name' => 'Bombay High Court',
                'type' => 'high',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
            ],
            [
                'name' => 'Delhi High Court',
                'type' => 'high',
                'city' => 'New Delhi',
                'state' => 'Delhi',
            ],
            [
                'name' => 'City Civil Court',
                'type' => 'civil',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
            ],
            [
                'name' => 'Sessions Court',
                'type' => 'session',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
            ],
            [
                'name' => 'Family Court Bandra',
                'type' => 'family',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
            ]
        ];

        foreach ($courts as $court) {
            Court::firstOrCreate(
                ['name' => $court['name']],
                $court
            );
        }
    }
}
