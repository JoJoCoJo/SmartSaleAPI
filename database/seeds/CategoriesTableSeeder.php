<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Product;

class CategoriesTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //factory(Category::class, 10)->create();

    	$categories = factory(Category::class, 10)->create();
    	$categories->each(function($category) {
			$products = factory(Product::class, 10)->make();
			$category->products()->saveMany($products);
		});

    }
}
