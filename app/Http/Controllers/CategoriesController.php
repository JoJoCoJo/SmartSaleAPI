<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
class CategoriesController extends Controller
{
    //
    public function getAll () {
    	return Category::All();
    }
}
