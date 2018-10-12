<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{	
	protected $primaryKey = 'id_category';
    public function products () {
    	return $this->hasMany(Product::class, 'category_id', 'id_category');
    }

    public function sales () {
    	return $this->hasMany(Sale::class, 'category_id', 'id_category');
    }
}
