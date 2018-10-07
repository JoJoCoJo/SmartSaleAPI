<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category () {
    	//return $this->belongsTo('App\Post', 'foreign_key', 'other_key');
    	return $this->belongsTo(Category::class, 'category_id', 'id_category');
    }
}
