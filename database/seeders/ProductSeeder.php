<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 75) as $product) {
            Product::create([
                'name'          =>  str()->random(50),
                'slug'          =>  str()->random(15),
                'color'         =>  Arr::random(['Red', 'Green', 'Blue', 'Yellow', 'White', 'Black', 'Orange', 'Violet', 'Indigo']),
                'size'          =>  Arr::random(['XXS', 'XS', 'SM', 'MD', 'L', 'XL', 'XXL']),
                'description'   =>  str()->random(250),
                'image'         =>  'https://picsum.photos/250/250'
            ]);
        }
    }
}
