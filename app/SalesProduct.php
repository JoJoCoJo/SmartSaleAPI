<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SalesProduct;

class SalesProduct extends Model {
	private $response = [
		'code' 		=>	null,
		'message'	=>	''
	];

	private $codeResponse = null;

	private $SalesProduct = SalesProduct::class;

	// This indicates to the validator what have to validate.
	private $rules = [
		/*'names' => 'required|min:3|max:50',
		'last_names' => 'nullable|max:50',
		'email' => 'required|email|min:5|max:80',
		'password' => 'required|min:7|max:15|alpha_num',
		'telephone' => 'nullable|numeric|digits_between:7,15'*/
	];

	//This indicates to the validator what messages to show when an error occurs.
	private $messages = [
		/*'names.required' => 'El nombre no puede quedar vacío.',
		'names.min' => 'El nombre debe tener al menos 3 carácteres.',
		'names.max' => 'El nombre debe tener máximo 50 carácteres.',
		'last_names.max' => 'Los apellidos deben tener máximo 50 carácteres.',
		'email.required' => 'El correo no puede quedar vacío.',
		'email.email' => 'El correo proporcionado no es válido.',
		'email.min' => 'El correo debe tener al menos 5 carácteres.',
		'email.max' => 'El correo debe tener máximo 80 carácteres.',
		'password.required' => 'La contraseña no puede quedar vacía.',
		'password.min' => 'La contraseña debe tener al menos 7 carácteres.',
		'password.max' => 'La contraseña debe tener máximo 15 carácteres.',
		'password.alpha_num' => 'La contraseña puede ser letras y números, no debe tener carácteres especiales. ej. (/*_.)',
		'telephone.numeric' => 'El teléfono sólo debe contener números.',
		'telephone.digits_between' => 'El teléfono debe tener al menos 7 números y máximo 15 números',*/
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
}
