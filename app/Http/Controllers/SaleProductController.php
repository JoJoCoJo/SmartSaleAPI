<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\SalesProduct;

class SaleProductController extends Controller {
    private $response = [
    	'code' 		=>	null,
    	'message'	=>	''
    ];

    private $codeResponse = null;

    private $SalesProduct = SalesProduct::class;

    // This indicates to the validator what have to validate.
    private $rules = [
		'sale_id' => 'required|integer',
		'product_id' => 'required|integer',
		'units_sales_product' => 'required|integer',
    ];

    //This indicates to the validator what messages to show when an error occurs.
    private $messages = [
		'sale_id.required' => 'Debe seleccionar una venta.',
		'sale_id.integer' => 'El id de la venta debe ser númerico.',
		'product_id.required' => 'Debe seleccionar un producto.',
		'product_id.integer' => 'El id del producto debe ser númerico.',
		'units_sales_product.required' => 'Debe ingresar una cantidad de productos',
		'units_sales_product.integer' => 'La cantidad de productos debe ser númerico.',
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

        // Get all Sales and products
    public function getAll ($method = null) {
        
        if ($method !== null) {
            $arrayMethods = explode(',', $method);

            $this->codeResponse = 200;
            $this->response['code']     = $this->codeResponse;
            $this->response['data']     = $this->SalesProduct::with($arrayMethods)->orderBy('sale_id', 'ASC')->get();
            $this->response['message']  = 'Datos obtenidos correctamente.';
        }else{
            $this->codeResponse = 200;
            $this->response['code']     = $this->codeResponse;
            $this->response['data']     = $this->SalesProduct::All();
            $this->response['message']  = 'Datos obtenidos correctamente.';
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
    		$newSalesProducts = new SalesProduct();
    		$newSalesProducts->sale_id = $request->input('sale_id');
    		$newSalesProducts->product_id = $request->input('product_id');
    		$newSalesProducts->units_sales_product = $request->input('units_sales_product');

    		if ($newSalesProducts->save()) {
    			$this->codeResponse 		= 201;
    			$this->response['code']		= $this->codeResponse;
    			$this->response['data']		= $newSalesProducts;
    			$this->response['message'] 	= 'Productos registrados en la venta con éxito.';
    		}else{
    			$this->codeResponse 		= 500;
    			$this->response['message'] 	= 'No se pudo completar el registro, intentelo más tarde.';
    		}
    	}

    	return response()->json($this->response, $this->codeResponse);
    }
}
