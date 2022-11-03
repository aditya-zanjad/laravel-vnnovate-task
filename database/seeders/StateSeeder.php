<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\Country;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country    =   Country::select(['id'])->where('name', 'India')->first();
        $states     =   ['Gujarat', 'Maharashtra', 'Delhi'];

        foreach ($states as $state) {
            State::create([
                'name'          =>  $state,
                'country_id'    =>  $country->id
            ]);
        }
    }
}
