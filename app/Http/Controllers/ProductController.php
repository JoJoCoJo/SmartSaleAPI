<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller {
	private $response = array(
		'code' 		=>	1,
		'data'		=>	array(),
		'message'	=>	''
	);
    public function index (){
    	$products = Product::All();
    	return $products;
    }

    public function store (Request $request){
    	//dd($request->all());
    	$codeResponse = 0;

    	$rules = [
    		'name' => 'required|min:3',
    		'price' => 'required|numeric|min:0',
    		'description' => 'required|min:10|max:30',
    		'long_description' => 'required|min:20|max:200'
    	];

    	$messages = [
    		'name.required' => 'El nombre no puede quedar vacío.',
    		'name.min' => 'El nombre debe tener al menos 3 carácteres.',
    		'price.required' => 'El precio no puede quedar vacío.',
    		'price.numeric' => 'El precio deben ser números.',
    		'price.min' => 'El precio no puede ser negativo.',
    		'description.required' => 'La descripción corta no puede quedar vacía.',
    		'description.min' => 'La descripción corta debe tener al menos 10 carácteres.',
    		'description.max' => 'La descripción corta debe tener al máximo 30 carácteres.',
    		'long_description.required' => 'La descripción larga no puede quedar vacío.',
    		'long_description.min' => 'La descripción corta debe tener al menos 20 carácteres.',
    		'long_description.max' => 'La descripción corta debe tener al máximo 200 carácteres.',
    	];

    	$validateData = \Validator::make($request->all(), $rules, $messages);

    	if ($validateData->fails()) {
    		$codeResponse = 422;
    		$this->response['code'] = $codeResponse;
    		$this->response['data'] = $validateData->errors();
    		$this->response['message'] = 'Campos requeridos';
    	}else{
    		$newProduct = new Product();
    		$newProduct->name 				= $request->input('name');
    		$newProduct->price 				= $request->input('price');
    		$newProduct->description 		= $request->input('description');
    		$newProduct->long_description 	= $request->input('long_description');
	    	if ($newProduct->save()) {
	    		$codeResponse = 201;
	    		$this->response['code'] 	= $codeResponse;
				$this->response['data'] 	= $newProduct;
				$this->response['message'] 	= 'Se ha guardado correctamente los datos.';
	    	}else{
	    		$codeResponse = 500;
	    		$this->response['code'] 	= $codeResponse;
	    		$this->response['message'] 	= 'No se pudo completar la acción, intentelo más tarde.';
	    	}
    	}
		/*try {
	    	
		} catch (PDOException $e) {
			$this->response['code'] 	= 3;
			$this->response['message'] 	= 'Ocurrió un error, favor de contactar al administrador.';
			$this->response['error'] 	= $e->getMessage();

			return $this->response;
			//return back()->withError($exception->getMessage())->withInput();			
		}*/
		return response()->json($this->response, $codeResponse);
    }

}