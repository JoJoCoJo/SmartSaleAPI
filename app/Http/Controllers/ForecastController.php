<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Forecast;

class ForecastController extends Controller {
	private $response = [
		'code' 		=>	null,
		'message'	=>	''
	];

	private $codeResponse = null;

	private $Forecast = Forecast::class;

	// This indicates to the validator what have to validate.
	private $rules = [
		/*'date_sale' => 'required|date',
		'total_units_sales' => 'required|integer',
		'type_sale' => 'required|integer',
		'user_id' => 'required|integer',
		'category_id' => 'nullable|integer',*/
	];

	//This indicates to the validator what messages to show when an error occurs.
	private $messages = [
		/*'date_sale.required' => 'La fecha no puede quedar vacío.',
		'date_sale.date' => 'El formato de la fecha no válido.',
		'total_units_sales.required' => 'El total de productos vendidos no puede quedar vació.',
		'total_units_sales.integer' => 'El total de productos vendidos debe ser númerico.',
		'type_sale.required' => 'Debe seleccionar un tipo de venta.',
		'type_sale.integer' => 'El tipo de venta debe ser númerico.',
		'user_id.required' => 'El usuario es requerido.',
		'user_id.integer' => 'El id del usuario debe ser númerico.',
		'category_id.integer' => 'El id de la categoria debe ser númerico.',*/
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
			$this->response['data'] 	= $this->Forecast::with($arrayMethods)->get();
			$this->response['message'] 	= 'Datos obtenidos correctamente.';
		}else{
			$this->codeResponse = 200;
			$this->response['code'] 	= $this->codeResponse;
			$this->response['data'] 	= $this->Forecast::All();
			$this->response['message'] 	= 'Datos obtenidos correctamente.';
		}
		return response()->json($this->response, $this->codeResponse);
	}
}