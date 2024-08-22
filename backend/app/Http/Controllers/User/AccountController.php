<?php

namespace App\Http\Controllers\User;

use App\Models\User;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function store(Request $request, User $user){
        try{
            $credentials = $request->all();
            $credentials['password'] = bcrypt($credentials['password']);
            if(count($user->where('email', $credentials['email'])->get()) > 0)
                return response()->json([
                    'status' => 500,
                    'data' => 'Este E-mail já foi utilizado!'
                ],500);
            $data = $user->validateData($credentials);
            if(array_key_exists('user_data', $data) ){
                return response($user->store($data['user_data']));
            }else{
                return response()->json(["msg" => "user data not verified", "data" => $data],500);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'data' => 'Erro no registro de usuário - AccountController',
                'msg' => $th->getMessage()
            ], 500);
        }
    }
    public function login(Request $request, User $user){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) { 
            $response = [
                        'status' => '0',
                        'error' => $validator->errors(),
                    ];

            Auth::logout();
            return response()->json([ 'validator_failed' => $response], 401);   
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = $user->where('email', $request->email)->select(['id','name', 'email'])->get()->first();
            $token = $user->createToken('token');
            return response()->json([
                'token' => $token->plainTextToken,
                'data' => [
                    'user' => $user,
                    'roles' => $request->user()->getRoleNames()
                ]
            ]);
        }else if(count($user->where('email', $request['email'])->get()) <= 0) {
            // Go back on error (or do what you want)
            Auth::logout();
            return response()->json([
                'msg' => 'USUÁRIO NÃO ENCONTRADO',
                'data' => $request->all()
            ], 500);
        } else {
            // Go back on error (or do what you want)
            Auth::logout();
            return response()->json([
                'msg' => 'DADOS INVÁLIDOS',
                'data' => $request->all()
            ], 401);
        }
    }
}
