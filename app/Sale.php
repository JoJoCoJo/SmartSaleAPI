<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model {

	protected $primaryKey = 'id_sale';

    public function user () {
    	return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function SalesWithProducts () {
    	return $this->belongsToMany(Product::class, 'sales_products', 'sale_id', 'product_id');
    }

}
