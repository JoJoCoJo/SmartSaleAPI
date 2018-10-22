<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

	protected $primaryKey = 'id_product';
	
    public function category () {
    	return $this->belongsTo(Category::class, 'category_id', 'id_category');
    }

    public function ProductsWithSales () {
    	return $this->belongsToMany(Sale::class, 'sales_products', 'product_id', 'sale_id');
    }
}
