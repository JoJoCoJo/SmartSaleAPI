<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Product;

class ProductsController extends Controller {

	private $response = [
		'code' 		=>	null,
		'message'	=>	''
	];

	private $codeResponse = null;

	private $Product = Product::class;

	// This indicates to the validator what have to validate.
	private $rules = [
		'name' => 'required|min:3|max:50',
		'price' => 'required|regex:/([0-9]{1,5}\.[0-9]{1,2})/',
		'image' => 'max:100',
		'category_id' => 'nullable|integer'
	];

	//This indicates to the validator what messages to show when an error occurs.
	private $messages = [
		'name.required' => 'El nombre no puede quedar vacío.',
		'name.min' => 'El nombre debe tener al menos 3 carácteres.',
		'name.max' => 'El nombre debe tener máximo 50 carácteres.',
		'price.required' => 'El precio no quedar vacío.',
		'price.regex' => 'El precio no tiene el formato correcto. ej. 57.99 ',
		'image.max' => 'La url de la imagen debe tener máximo 100 carácteres.',
		'category_id.integer' => 'El id debe ser númerico.'
	];

	private function Validator (Array $params) {
		if (!isset($params['dataToValidate'])) {
			return 'dataToValidate is requerid.';
		}elseif (!isset($params['rules'])) {
			return 'rules is requerid.';
		}else{
			if (isset($params['messages'])) {
				return Validator::make($params['dataToValidate'], $params['rules'], $params['messages']);
			}else{
				return Validator::make($params['dataToValidate'], $params['rules']);
			}
		}
	}
	
	// Get all products without relationships
	public function getAll () {
		$this->codeResponse = 200;
		$this->response['code'] 	= $this->codeResponse;
		$this->response['data'] 	= $this->Product::All();
		$this->response['message'] 	= 'Datos obtenido correctamente.';

		return response()->json($this->response, $this->codeResponse);
	}

	public function create (Request $request) {
		$params = [
			'dataToValidate' => $request->all(),
			'rules' => $this->rules,
			'messages' => $this->messages
		];

		$validateCreate = $this->Validator($params);

		if ($validateCreate->fails()) {
			$this->codeResponse			= 422;
			$this->response['code'] 	= $this->codeResponse;
			$this->response['errors'] 	= $validateCreate->errors();
			$this->response['message'] 	= 'Han ocurrido algunos errores.';
		}else{
			$newProduct 			 = new Product();
			$newProduct->name 		 = $request->input('name');
			$newProduct->price 		 = $request->input('price');
			$newProduct->image 		 = $request->input('image');
			$newProduct->category_id = $request->input('category_id');

			if ($newProduct->save()) {
				$this->codeResponse 		= 201;
				$this->response['code']		= $this->codeResponse;
				$this->response['data']		= $newProduct;
				$this->response['message'] 	= 'Registro creado con éxito.';
			}else{
				$this->codeResponse 		= 500;
				$this->response['message'] 	= 'No se pudo completar el registro, intentelo más tarde.';
			}
		}

		return response()->json($this->response, $this->codeResponse);
	}
}
