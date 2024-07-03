<?php

namespace App\Http\Controllers\User;

use App\Models\User;

use App\Http\Controllers\Controller;
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
}
