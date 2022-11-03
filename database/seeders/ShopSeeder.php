<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Shop;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $citiesIds = City::select(['id'])
            ->get()
            ->map(function ($city) {
                return $city->id;
            })->toArray();

        foreach (range(1, 50) as $shop) {
            Shop::create([
                'name'      =>  str()->random(50),
                'address'   =>  str()->random(500),
                'city_id'   =>  Arr::random($citiesIds)
            ]);
        }
    }
}
