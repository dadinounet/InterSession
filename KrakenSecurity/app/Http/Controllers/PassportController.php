<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 18/01/18
 * Time: 11:31
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class PassportController
{
    public $successStatus = 200;

    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] = $user->createToken('Krakentoken')->accessToken;
            $user_id = $user->id;
            $current = new \DateTime();
            $dateConnection = User::where('id', $user_id)->update(array('connection_date' => $current->format('Y-m-d H:i:s')));
            $success['id'] = $user_id;
            $success['name'] =  $user->name;
            $success['connection_date_update'] = $dateConnection;
            return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',

        ]);

        if ($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 401);
        }
        else {
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $success['token'] =  $user->createToken('Krakentoken')->accessToken;
            $success['name'] =  $user->name;
            $success['id'] = $user->id;
            return response()->json(['success' => $success], $this->successStatus);
        }
    }

    /*public function getDetails(){
        $user = Auth::user();
        return response()->json(['success' => $user],$this->successStatus);
    }*/

    public function disconnect(){
        $user = Auth::user();
        if (Auth::check()) {
            $success['revoke_token'] = $user->token()->revoke();
            return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Not connected'], 401);
        }
    }

}