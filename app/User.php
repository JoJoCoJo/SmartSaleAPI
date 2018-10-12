<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

	protected $primaryKey = 'id_user';
	
    public function sales () {
    	return $this->hasMany(Sale::class, 'user_id', 'id_user');
    }
}
