<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
class CategoriesController extends Controller {
    
    private $response = array(
			'code' 		=>	null,
			'data'		=>	array(),
			'message'	=>	''
		);
    private $codeResponse = null;
    private $Category = Category::class;

    
    // Get all categories without relationships
    public function getAll () {
    	$this->codeResponse = 200;
    	$this->response['code'] 	= $this->codeResponse;
		$this->response['data'] 	= $this->Category::All();
		$this->response['message'] 	= 'Datos obtenido correctamente.';

    	return response()->json($this->response, $this->codeResponse);
    }

    // Get all categories with products relationship
    public function getAllWithProducts () {
    	$this->codeResponse = 200;
    	$this->response['code'] 	= $this->codeResponse;
		$this->response['data'] 	= $this->Category::with('products')->get();
		$this->response['message'] 	= 'Datos obtenido correctamente.';

    	return response()->json($this->response, $this->codeResponse);
    }

    // Get all categories with sales relationship
    public function getAllWithSales () {
    	$this->codeResponse = 200;
    	$this->response['code'] 	= $this->codeResponse;
		$this->response['data'] 	= $this->Category::with('sales')->get();
		$this->response['message'] 	= 'Datos obtenido correctamente.';

    	return response()->json($this->response, $this->codeResponse);
    }

    // Get all categories with all relationships
    public function getAllWithAll () {
    	$this->codeResponse = 200;
    	$this->response['code'] 	= $this->codeResponse;
		$this->response['data'] 	= $this->Category::with('products')->with('sales')->get();
		$this->response['message'] 	= 'Datos obtenido correctamente.';

    	return response()->json($this->response, $this->codeResponse);
    }
}
