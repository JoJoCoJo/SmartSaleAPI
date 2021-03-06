<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Category;

class CategoriesController extends Controller {
    
    private $response = [
		'code' 		=>	null,
		'message'	=>	''
	];

    private $codeResponse = null;

    private $Category = Category::class;

    // This indicates to the validator what have to validate.
    private $rules = [
    	'name' => 'required|min:5|max:50',
    	'description' => 'nullable|min:10|max:150',
		'user_id' => 'required|integer',
    ];

    //This indicates to the validator what messages to show when an error occurs.
    private $messages = [
    	'name.required' => 'El nombre no puede quedar vacío.',
    	'name.min' => 'El nombre debe tener al menos 5 carácteres.',
    	'name.max' => 'El nombre debe tener máximo 50 carácteres.',
    	'description.min' => 'La descripción debe tener menos 10 carácteres.',
    	'description.max' => 'La descripción debe tener máximo 150 carácteres.',
    	'user_id.required' => 'El usuario es requerido.',
		'user_id.integer' => 'El id del usuario debe ser númerico.',
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

    // Get all categories without relationships
    public function getAll ($method = null) {

    	if ($method !== null) {
    		$arrayMethods = explode(',', $method);
    		
    		$this->codeResponse = 200;
    		$this->response['code'] 	= $this->codeResponse;
    		$this->response['data'] 	= $this->Category::with($arrayMethods)->get();
    		$this->response['message'] 	= 'Datos obtenidos correctamente.';
    	}else{
    		$this->codeResponse = 200;
	    	$this->response['code'] 	= $this->codeResponse;
			$this->response['data'] 	= $this->Category::All();
			$this->response['message'] 	= 'Datos obtenidos correctamente.';
    	}

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
			$newCategory = new Category();
			$newCategory->name = $request->input('name');
			$newCategory->description = $request->input('description');
			$newCategory->user_id = $request->input('user_id');

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

	public function delete (Request $request) {

		$rules = [
			'id_category' => 'required|integer',
		];

		$messages = [
			'id_category.required' => 'El id es requerido.',
			'id_category.integer' => 'El id debe ser númerico.',
		];

		$params = [
			'dataToValidate' => $request->all(),
			'rules' => $rules,
			'messages' => $messages
		];

		$validateDelete = $this->Validator($params);

		if ($validateDelete->fails()) {
			$this->codeResponse			= 422;
			$this->response['code'] 	= $this->codeResponse;
			$this->response['errors'] 	= $validateDelete->errors();
			$this->response['message'] 	= 'Han ocurrido algunos errores.';
		}else{

			$findCategoryToDelete = $this->Category::find($request->id_category);
			
			if ($findCategoryToDelete->delete()) {
				$this->codeResponse 		= 201;
				$this->response['code']		= $this->codeResponse;
				$this->response['message'] 	= 'Registro eliminado con éxito.';
			}else{
				$this->codeResponse 		= 500;
				$this->response['code']		= $this->codeResponse;
				$this->response['message'] 	= 'No se pudo eliminar el registro, intentelo más tarde.';
			}
		}

		return response()->json($this->response, $this->codeResponse);
	}

	public function update (Request $request) {

		$rules = [
			'id_category' => 'required|integer',
		];

		$messages = [
			'id_category.required' => 'El id es requerido.',
			'id_category.integer' => 'El id debe ser númerico.',
		];

		$paramsId = [
			'dataToValidate' => $request->all(),
			'rules' => $rules,
			'messages' => $messages
		];

		$validateUpdateID = $this->Validator($paramsId);

		if ($validateUpdateID->fails()) {
			$this->codeResponse			= 422;
			$this->response['code'] 	= $this->codeResponse;
			$this->response['errors'] 	= $validateUpdateID->errors();
			$this->response['message'] 	= 'Han ocurrido algunos errores.';
		}else{
			$paramsUpdateData = [
				'dataToValidate' => $request->all(),
				'rules' => $this->rules,
				'messages' => $this->messages
			];

			$validateUpdateData = $this->Validator($paramsUpdateData);

			if ($validateUpdateData->fails()) {
				$this->codeResponse			= 422;
				$this->response['code'] 	= $this->codeResponse;
				$this->response['errors'] 	= $validateUpdateData->errors();
				$this->response['message'] 	= 'Han ocurrido algunos errores.';
			}else{
				
				$findCategoryToUpdate = $this->Category::find($request->id_category);
				$findCategoryToUpdate->name = $request->input('name');

				if ($request->input('description') !== NULL) {
				 	$findCategoryToUpdate->description = $request->input('description');
				}

				if ($findCategoryToUpdate->save()) {
					$this->codeResponse			= 202;
					$this->response['code'] 	= $this->codeResponse;
					$this->response['message'] 	= 'Registro actualizado con éxito.';
				}else{
					$this->codeResponse 		= 500;
					$this->response['code']		= $this->codeResponse;
					$this->response['message'] 	= 'No se pudo actualizar el registro, intentelo más tarde.';
				}
			}
		}

		return response()->json($this->response, $this->codeResponse);
	}
}
