<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $citiesIds = City::select()
            ->get()
            ->map(function ($city) {
                return $city->id;
            })->toArray();

        foreach (range(0, 1000) as $number) {
            User::create([
                'name'              =>  str()->random(20),
                'email'             =>  str()->random(10) . '@email.com',
                'password'          =>  bcrypt('password@laravel'),
                'gender'            =>  Arr::random(['m', 'f', 'o']),
                'city_id'           =>  Arr::random($citiesIds),
            ]);
        }
    }
}
