<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;

class UsersController extends Controller {

    private $response = [
    	'code' 		=>	null,
    	'message'	=>	''
    ];

    private $codeResponse = null;

    private $User = User::class;

    // This indicates to the validator what have to validate.
    private $rules = [
    	'names' => 'required|min:3|max:50',
    	'last_names' => 'nullable|max:50',
    	'email' => 'required|email|unique:users|min:5|max:80',
    	'password' => 'required|min:7|max:15|alpha_num',
    	'telephone' => 'nullable|numeric|digits_between:7,15'
    ];

    //This indicates to the validator what messages to show when an error occurs.
    private $messages = [
    	'names.required' => 'El nombre no puede quedar vacío.',
    	'names.min' => 'El nombre debe tener al menos 3 carácteres.',
    	'names.max' => 'El nombre debe tener máximo 50 carácteres.',
    	'last_names.max' => 'Los apellidos deben tener máximo 50 carácteres.',
    	'email.required' => 'El correo no puede quedar vacío.',
    	'email.email' => 'El correo proporcionado no es válido.',
    	'email.unique' => 'Este correo ya esta siendo usado.',
    	'email.min' => 'El correo debe tener al menos 5 carácteres.',
    	'email.max' => 'El correo debe tener máximo 80 carácteres.',
    	'password.required' => 'La contraseña no puede quedar vacía.',
    	'password.min' => 'La contraseña debe tener al menos 7 carácteres.',
    	'password.max' => 'La contraseña debe tener máximo 15 carácteres.',
    	'password.alpha_num' => 'La contraseña puede ser letras y números, no debe tener carácteres especiales. ej. (/*_.)',
    	'telephone.numeric' => 'El teléfono sólo debe contener números.',
    	'telephone.digits_between' => 'El teléfono debe tener al menos 7 números y máximo 15 números',
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
    	$this->response['data'] 	= $this->User::All();
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
    		$newUser = new User();
    		$newUser->names = $request->input('names');
    		$newUser->last_names = $request->input('last_names');
    		$newUser->email = $request->input('email');
    		$newUser->password = hash('sha256', $request->input('password'));
    		$newUser->telephone = $request->input('telephone');

    		if ($newUser->save()) {
    			unset($newUser->password);
    			$this->codeResponse 		= 201;
    			$this->response['code']		= $this->codeResponse;
    			$this->response['data']		= $newUser;
    			$this->response['message'] 	= 'Usuario creado con éxito.';
    		}else{
    			$this->codeResponse 		= 500;
    			$this->response['message'] 	= 'No se pudo completar el registro, intentelo más tarde.';
    		}
    	}

    	return response()->json($this->response, $this->codeResponse);
    }

    public function delete (Request $request) {
    	$rules = [
    		'id_user' => 'required|integer',
    	];

    	$messages = [
    		'id_user.required' => 'El id es requerido.',
    		'id_user.integer' => 'El id debe ser númerico.',
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
    		$findUserToDelete = $this->User::find($request->id_user);

    		if ($findUserToDelete->delete()) {
    			$this->codeResponse 		= 201;
    			$this->response['code']		= $this->codeResponse;
    			$this->response['message'] 	= 'Usuario eliminado con éxito.';
    		}else{
    			$this->codeResponse 		= 500;
    			$this->response['code']		= $this->codeResponse;
    			$this->response['message'] 	= 'No se pudo eliminar el usuario, intentelo más tarde.';
    		}
    	}

    	return response()->json($this->response, $this->codeResponse);
    }

    
}
