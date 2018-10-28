<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Product;
use App\User;
use App\Sale;
use App\SalesProduct;
use App\Forecast;

class GeneralSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        factory(Category::class, 10)->create();
        factory(Product::class, 100)->create();
        factory(User::class, 50)->create();
        factory(Sale::class, 500)->create();
        factory(Forecast::class, 1500)->create();
        factory(SalesProduct::class, 1000)->create();
    }
}
