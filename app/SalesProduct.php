<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesProduct extends Model {
	
	public function products () {
		return $this->hasMany(Product::class, 'id_product', 'product_id');
	}

	public function sales () {
		return $this->hasMany(Sale::class, 'id_sale', 'sale_id');
	}
}
