<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Validator;

class adminController extends Controller
{
    //
    function index(Request $request)
    {
        $rules = array(
            'admin_username'=>'required',
            'admin_pass' => 'required'
        );
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            $response = [
                'success' => false,
                'result' => $validator->errors()
            ];
            return response($response, 400);
        }else{
            $admin= Admin::where('admin_username', $request->admin_username)->first();
            // print_r($data);
            if (!$admin || !Hash::check($request->admin_pass, $admin->admin_pass)) {
                return response([
                    'success' => false,
                    'message' => ['These credentials do not match our records.']
                ], 400);
            }
        
            $token = $admin->createToken('my-app-token')->plainTextToken;
        
            $response = [
                'success' => true,
                'admin' => $admin,
                'token' => $token
            ];
            return response($response, 201);
        }
    }
}
