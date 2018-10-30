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
		'type_forecast' => 'required|integer',
		'forecastData' => 'required|json',
		'sale_id' => 'required|integer',
	];

	//This indicates to the validator what messages to show when an error occurs.
	private $messages = [
		'type_forecast.required' => 'Debe seleccionar un tipo de pronóstico.',
		'type_forecast.integer' => 'El tipo de pronóstico debe ser númerico.',
		'forecastData.required' => 'Los datos del pronóstico son requeridos.',
		'forecastData.json' => 'Los datos del pronóstico deben ser formato JSON.',
		'sale_id.required' => 'La venta es requerida.',
		'sale_id.integer' => 'El id de la venta debe ser númerico.',
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
			$newForecast 			= new Forecast();
			$newForecast->type_forecast = $request->input('type_forecast');
			$newForecast->forecastData = $request->input('forecastData');
			$newForecast->sale_id = $request->input('sale_id');

			if ($newForecast->save()) {
				$this->codeResponse 		= 201;
				$this->response['code']		= $this->codeResponse;
				$this->response['data']		= $newForecast;
				$this->response['message'] 	= 'Registro realizado con éxito.';
			}else{
				$this->codeResponse 		= 500;
				$this->response['message'] 	= 'No se pudo completar el registro, intentelo más tarde.';
			}			
		}

		return response()->json($this->response, $this->codeResponse);
	}
}