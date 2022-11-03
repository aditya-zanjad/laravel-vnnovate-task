<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\Product;
use App\Models\ProductShop;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;

class ProductShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shopsIds = Shop::select(['id'])
            ->get()
            ->map(function ($shop) {
                return $shop->id;
            })->toArray();

        $productsIds = Product::select(['id'])
            ->get()
            ->map(function ($product) {
                return $product->id;
            })->toArray();

        /* foreach (range (1, 150) as $shopProduct) {
            ProductShop::create([
                'shop_id'       =>  Arr::random($shopsIds),
                'product_id'    =>  Arr::random($productsIds)
            ]);
        } */

        // Make sure that each shop has at least 5-15 products
        foreach ($shopsIds as $shopId) {
            $selectedProductsIds = Arr::random($productsIds, mt_rand(5, 15));

            foreach ($selectedProductsIds as $productId) {
                $productShopExists = ProductShop::where('product_id', $productId)
                    ->where('shop_id', $shopId)
                    ->first();

                if ($productShopExists) {
                    continue;
                }

                ProductShop::create([
                    'product_id'    =>  $productId,
                    'shop_id'       =>  $shopId
                ]);
            }
        }

        // Make sure that each product belongs to at least 5-15 shops
        foreach ($productsIds as $productId) {
            $selectedShopsIDs = Arr::random($shopsIds, mt_rand(4, 5));
            foreach ($selectedShopsIDs as $shopId) {
                $productShopExists = ProductShop::where('product_id', $productId)
                    ->where('shop_id', $shopId)
                    ->first();

                if ($productShopExists) {
                    continue;
                }

                ProductShop::create([
                    'product_id'    =>  $productId,
                    'shop_id'       =>  $shopId
                ]);
            }
        }
    }
}
