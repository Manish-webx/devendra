<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Location;
use App\Models\Result;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::factory()->create([
            'name' => 'Devendra',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        // Locations
        $locationsData = [
            ['name' => 'FARIDABAD', 'result_time' => '06:00 PM', 'sort_order' => 1],
            ['name' => 'GHAZIABAD', 'result_time' => '08:30 PM', 'sort_order' => 2],
            ['name' => 'GALI', 'result_time' => '11:15 PM', 'sort_order' => 3],
            ['name' => 'DESAWAR', 'result_time' => '05:10 AM', 'sort_order' => 4],
            ['name' => 'DELHI BAZAR', 'result_time' => '03:00 PM', 'sort_order' => 5],
            
            ['name' => 'CHAR MINAR', 'result_time' => '04:00 PM', 'sort_order' => 6],
            ['name' => 'OLD DELHI', 'result_time' => '05:00 PM', 'sort_order' => 7],
            ['name' => 'SADAR BAZAR', 'result_time' => '06:00 PM', 'sort_order' => 8],
            ['name' => 'DANGAL', 'result_time' => '07:00 PM', 'sort_order' => 9],
            ['name' => 'NEW PUNJAB EXPRESS', 'result_time' => '08:00 PM', 'sort_order' => 10],

            ['name' => 'NEW DELHI BAZAR', 'result_time' => '09:00 PM', 'sort_order' => 11],
            ['name' => 'PATNA CITY', 'result_time' => '10:00 PM', 'sort_order' => 12],
            ['name' => 'RAJASTHAN BAZAR', 'result_time' => '11:00 PM', 'sort_order' => 13],
            ['name' => 'CHOTU TAJ', 'result_time' => '12:00 AM', 'sort_order' => 14],
            ['name' => 'DELHI NOON', 'result_time' => '01:00 PM', 'sort_order' => 15],

            ['name' => 'JAI GANGA', 'result_time' => '02:00 PM', 'sort_order' => 16],
            ['name' => 'TAJ', 'result_time' => '03:00 PM', 'sort_order' => 17],
            ['name' => 'SAI RAM', 'result_time' => '04:00 PM', 'sort_order' => 18],
            ['name' => 'HARYANA BAZAR', 'result_time' => '05:00 PM', 'sort_order' => 19],
            ['name' => 'SHRI GANESH', 'result_time' => '06:00 PM', 'sort_order' => 20],

            ['name' => 'KASHIPUR', 'result_time' => '07:00 PM', 'sort_order' => 21],
            ['name' => 'NEW GANESH', 'result_time' => '08:00 PM', 'sort_order' => 22],
            ['name' => 'PATNA', 'result_time' => '09:00 PM', 'sort_order' => 23],
            ['name' => 'PUNJAB DAY', 'result_time' => '10:00 PM', 'sort_order' => 24],
            ['name' => 'NEW FARIDABAD', 'result_time' => '11:00 PM', 'sort_order' => 25],
        ];

        foreach ($locationsData as $data) {
            Location::create($data);
        }

        // Dummy Results for the first 5 days of the current month
        $locations = Location::all();
        $today = Carbon::now();

        for ($day = 1; $day <= 5; $day++) {
            $date = Carbon::create($today->year, $today->month, $day)->toDateString();
            
            foreach ($locations as $loc) {
                Result::create([
                    'location_id' => $loc->id,
                    'result_date' => $date,
                    'lucky_number' => str_pad(rand(0, 99), 2, '0', STR_PAD_LEFT)
                ]);
            }
        }
        
        // Ensure today also has results
        foreach ($locations as $loc) {
             Result::updateOrCreate([
                    'location_id' => $loc->id,
                    'result_date' => $today->toDateString(),
             ], [
                    'lucky_number' => str_pad(rand(0, 99), 2, '0', STR_PAD_LEFT)
             ]);
        }
    }
}
