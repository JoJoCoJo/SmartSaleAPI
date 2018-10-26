<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Sale;

class SalesController extends Controller {
	private $response = [
		'code' 		=>	null,
		'message'	=>	''
	];

	private $codeResponse = null;

	private $Sale = Sale::class;

	// This indicates to the validator what have to validate.
	private $rules = [
		'date_sale' => 'required|date',
		'total_units_sales' => 'required|integer',
		'type_sale' => 'required|integer',
		'user_id' => 'required|integer',
		'category_id' => 'nullable|integer',
	];

	//This indicates to the validator what messages to show when an error occurs.
	private $messages = [
		'date_sale.required' => 'La fecha no puede quedar vacío.',
		'date_sale.date' => 'El formato de la fecha no válido.',
		'total_units_sales.required' => 'El total de productos vendidos no puede quedar vació.',
		'total_units_sales.integer' => 'El total de productos vendidos debe ser númerico.',
		'type_sale.required' => 'Debe seleccionar un tipo de venta.',
		'type_sale.integer' => 'El tipo de venta debe ser númerico.',
		'user_id.required' => 'El usuario es requerido.',
		'user_id.integer' => 'El id del usuario debe ser númerico.',
		'category_id.integer' => 'El id de la categoria debe ser númerico.',
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
	public function getAll ($method = null) {
		if ($method !== null) {
			$arrayMethods = explode(',', $method);
			
			$this->codeResponse = 200;
			$this->response['code'] 	= $this->codeResponse;
			$this->response['data'] 	= $this->Sale::with($arrayMethods)->get();
			$this->response['message'] 	= 'Datos obtenidos correctamente.';
		}else{
			$this->codeResponse = 200;
			$this->response['code'] 	= $this->codeResponse;
			$this->response['data'] 	= $this->Sale::All();
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
			$newSale 			= new Sale();
			$newSale->date_sale = $request->input('date_sale');
			$newSale->total_units_sales = $request->input('total_units_sales');
			$newSale->type_sale = $request->input('type_sale');
			$newSale->user_id = $request->input('user_id');
			$newSale->category_id = $request->input('category_id');

			if ($newSale->save()) {
				unset($newSale->password);
				$this->codeResponse 		= 201;
				$this->response['code']		= $this->codeResponse;
				$this->response['data']		= $newSale;
				$this->response['message'] 	= 'Venta registrada con éxito.';
			}else{
				$this->codeResponse 		= 500;
				$this->response['message'] 	= 'No se pudo completar el registro, intentelo más tarde.';
			}			
		}

		return response()->json($this->response, $this->codeResponse);;
	}

	public function delete (Request $request) {
		$rules = [
			'id_sale' => 'required|integer',
		];

		$messages = [
			'id_sale.required' => 'El id es requerido.',
			'id_sale.integer' => 'El id debe ser númerico.',
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
			$findSaleToDelete = $this->Sale::find($request->id_sale);

			if ($findSaleToDelete->delete()) {
				$this->codeResponse 		= 201;
				$this->response['code']		= $this->codeResponse;
				$this->response['message'] 	= 'Venta eliminada con éxito.';
			}else{
				$this->codeResponse 		= 500;
				$this->response['code']		= $this->codeResponse;
				$this->response['message'] 	= 'No se pudo eliminar la venta, intentelo más tarde.';
			}
		}

		return response()->json($this->response, $this->codeResponse);
	}
}
