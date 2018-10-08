<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public function product () {
    	return $this->belongsTo(Product::class, 'product_id', 'id_product');
    }

    public function user () {
    	return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}
