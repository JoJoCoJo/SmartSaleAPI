<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Category;

class CategoriesController extends Controller {
    
    private $response = array(
			'code' 		=>	null,
			'message'	=>	''
		);
    private $codeResponse = null;
    private $Category = Category::class;

    // This indicates to the validator what have to validate.
    private $rules = [
    	'name' => 'required|min:5|max:50',
    	'description' => 'min:10|max:150'
    ];

    //This indicates to the validator what messages to show when an error occurs.
    private $messages = [
    	'name.required' => 'El nombre no puede quedar vacío.',
    	'name.min' => 'El nombre debe tener al menos 5 carácteres.',
    	'name.max' => 'El nombre debe tener máximo 50 carácteres.',
    	'description.min' => 'La descripción debe tener al menos 10 carácteres.',
    	'description.max' => 'La descripción debe tener al máximo 150 carácteres.'
    ];

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

	public function create (Request $request) {

		$validateData = Validator::make($request->all(), $this->rules, $this->messages);

		if ($validateData->fails()) {
			$this->codeResponse			= 422;
			$this->response['code'] 	= $this->codeResponse;
			$this->response['errors'] 	= $validateData->errors();
			$this->response['message'] 	= 'Han ocurrido algunos errores.';
		}else{
			$newCategory = new Category();
			$newCategory->name = $request->input('name');
			$newCategory->description = $request->input('description');

			if ($newCategory->save()) {
				$this->codeResponse 		= 201;
				$this->response['code']		= $this->codeResponse;
				$this->response['data']		= $newCategory;
				$this->response['message'] 	= 'Registro creado con éxito.';
			}else{
				$this->codeResponse 		= 500;
				$this->response['message'] 	= 'No se pudo completar el registro, intentelo más tarde.';
			}
		}

		return response()->json($this->response, $this->codeResponse);
	}
}
