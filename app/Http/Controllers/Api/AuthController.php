<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clienti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function login(Request $request){
        if(Auth::guard('client')->attempt(['email' => $request->email, 'password' => $request->password ])){
            $auth = Auth::guard('client')->user();
            $success['token'] =  $auth->createToken('LaravelSanctumAuth')->plainTextToken; 
            $success['name'] =  $auth->nome.' '.$auth->cognome;

            return $this->handleResponse($success, 'Benvenuto!');
        }else{
            return $this->handleError('Unauthorised.', ['error'=>'Unauthorised']);
        }   
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'cognome' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return $this->handleError($validator->errors());       
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = Clienti::create($input);
        $success['token'] =  $user->createToken('LaravelSanctumAuth')->plainTextToken;
        $success['name'] = $user->nome.' '.$user->cognome;

        return $this->handleResponse($success, 'Cliente Registrato!');
    }
}
