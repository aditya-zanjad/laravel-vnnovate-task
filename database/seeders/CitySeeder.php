<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = State::select(['id', 'name'])->get()->toArray();

        // Organize fetched 'states' data
        foreach ($states as $state => $info) {
            $states[str()->lower($info['name'])] = $info['id'];
            unset($states[$state]);
        }

        $cities = [
            [
                'name'  =>  'Ahmedabad',
                'state' =>  'Gujarat'
            ],
            [
                'name'  =>  'Baroda',
                'state' =>  'Gujarat'
            ],
            [
                'name'  =>  'Surat',
                'state' =>  'Gujarat'
            ],
            [
                'name'  =>  'Delhi',
                'state' =>  'Delhi'
            ],
            [
                'name'  =>  'Mumbai',
                'state' =>  'Maharashtra'
            ]
        ];

        // Organize & save 'cities' data
        foreach ($cities as $city => $details) {
            $stateName = str()->lower($details['state']);

            if (array_key_exists(str()->lower($cities[$city]['state']), $states)) {
                City::create([
                    'name'      =>  $details['name'],
                    'state_id'  =>  $states[$stateName]
                ]);
            }
        }
    }
}
