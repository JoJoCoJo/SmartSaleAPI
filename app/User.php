<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

	protected $primaryKey = 'id_user';
	
    public function sales () {
    	return $this->hasMany(Sale::class, 'user_id', 'id_user');
    }

    public function products () {
    	return $this->hasMany(Product::class, 'user_id', 'id_user');
    }

    public function categories () {
    	return $this->hasMany(Category::class, 'user_id', 'id_user');
    }

    public function forecasts () {
    	return $this->hasMany(Forecast::class, 'user_id', 'id_user');
    }
}
