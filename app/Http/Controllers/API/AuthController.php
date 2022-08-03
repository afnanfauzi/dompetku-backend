<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;

class AuthController extends BaseController
{
    public function getUser(Request $request) {
        return $request->user();
    }

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            if($user->is_active == 1){
                if($user->roles[0]['id'] == 1){
                    $success['token'] =  $user->createToken('access_token', ['administrator'])->plainTextToken; 
                }else{
                    $success['token'] =  $user->createToken('access_token', ['user'])->plainTextToken; 
                }
                
                $success['token_type'] =  'Bearer'; 
                $success['id_user'] =  $user->id;
                $success['name'] =  $user->name;
                $success['role'] =  $user->roles[0]['name'];

                return $this->sendResponse($success, 'User login successfully.');
            }else{
                return $this->sendError('Unauthorized.', ['error'=>'User not activated']);
            }
        } 
        else{ 
            return $this->sendError('Unauthorized.', ['error'=>'Unauthorized']);
        } 
    }

    public function logout(){
        $user = request()->user();
        $user->currentAccessToken()->delete();
        if($user){
            return $this->sendResponse([], 'User logout successfully.');
        }else{
            return $this->sendError('Failed.', ['error'=>'User not login']);
        }
    }
}