<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;

class userController extends Controller
{
    //
    function login(Request $request)
    {
        $rules = array(
            'username'=>'required',
            'password' => 'required'
        );
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            $response = [
                'success' => false,
                'result' => $validator->errors()
            ];
            return response($response, 400);
        }else{
            $user= User::where('username', $request->username)->first();
            //print_r($data);
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'success' => false,
                    'message' => ['These credentials do not match our records.']
                ], 400);
            }
        
            $token = $user->createToken('my-app-token')->plainTextToken;
        
            $response = [
                'success' => true,
                'user' => $user,
                'token' => $token
            ];
            return response($response, 201);
        }
    }
    function showusers()
    {
        $user = User::select('id','camp_id','name','mobile','id_proofe_type','id_proof_no','status')
        ->where('type', '!=', 'Admin')->get();
        if(count($user)){
            $response = [
                'success' => true,
                'result' => $user
            ];
            return response($response, 200);
        }else{
            $response = [
                'success' => false,
                'result' => 'No user found.'
            ];
            return response($response, 400);
        }
    }
    function showuser($id)
    {
        $user = User::select('id','camp_id','name','mobile','id_proofe_type','id_proof_no','status')
        ->where('id', '=', $id)->get();
        if(count($user)){
            $response = [
                'success' => true,
                'result' => $user
            ];
            return response($response, 200);
        }else{
            $response = [
                'success' => false,
                'result' => 'No user found.'
            ];
            return response($response, 400);
        }
    }
    function insertuser(Request $request)
    {
        /*$rules = array(
            'camp_id'=>'required|integer',
            'name' => 'required',
            'mobile' => 'required|integer',
            'id_proofe_type'=>'required',
            'id_proof_no' => 'required',
            'status' => 'required'
        );*/
        $rules = array(
            'name' => 'required',
            'mobile' => 'required|integer'
        );
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            $response = [
                'success' => false,
                'result' => $validator->errors()
            ];
            return response($response, 400);
        }else{
            $user = new User;
            if($req->has('camp_id')){
                $user->camp_id = $request->camp_id;
            }
            $user->name = $request->name;
            if($req->has('status')){
                $user->status = $request->status;
            }
            $user->mobile = $request->mobile;
            if($req->has('whatsup_mobile')){
                $user->whatsup_mobile = $request->whatsup_mobile;
            }
            if($req->has('id_proofe_type')){
                $user->id_proofe_type = $request->id_proofe_type;
            }
            if($req->has('id_proof_no')){
                $user->id_proof_no = $request->id_proof_no;
            }
            $user->save();
            $response = [
                'success' => true,
                'result' => 'New user registered'
            ];
            return response($response, 200);
        }
    }
    function updateuser(Request $request)
    {
        $rules = array(
            'camp_id'=>'required|integer',
            'name' => 'required',
            'mobile' => 'required|integer',
            'whatsup_mobile' => 'required|integer',
            'id_proofe_type'=>'required',
            'id_proof_no' => 'required',
            'id' => 'required|integer'
        );
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            $response = [
                'success' => false,
                'result' => $validator->errors()
            ];
            return response($response, 400);
        }else{
            $user = User::where([
                ['id', '=', $request->id]
            ])->get();
            if(count($user)){
                $affected = DB::table('users')
                ->where('id', $request->id)
                ->update(
                    ['camp_id' => $request->admin_id,
                    'name' => $request->name,
                    'mobile' => $request->mobile,
                    'whatsup_mobile' => $request->whatsup_mobile,
                    'id_proofe_type' => $request->id_proofe_type,
                    'id_proof_no' => $request->id_proof_no,
                    'status' => $request->status,
                ]);
                $response = [
                    'success' => true,
                    'result' => 'User data updated'
                ];
                return response($response, 200);
            }else{
                $response = [
                    'success' => false,
                    'result' => "Data not found"
                ];
                return response($response, 400);
            }
        }
    }
    function deleteuser($id)
    {  
        $deleted = DB::table('users')->where([
            ['id', '=', $id],
            ['type', '!=', 'Admin'],
        ])->delete();
        $response = [
            'success' => true,
            'result' => 'Data deleted'
        ];
        return response($response, 200);
    }
    function showadmins()
    {
        $user = User::select('id','name','mobile','username','password','status','role')
        ->where('type', '=', 'Admin')->get();
        if(count($user)){
            $response = [
                'success' => true,
                'result' => $user
            ];
            return response($response, 200);
        }else{
            $response = [
                'success' => false,
                'result' => 'No admin found.'
            ];
            return response($response, 400);
        }
    }
    function showadmin($id)
    {
        $user = User::select('id','name','mobile','username','password','status','role')
        ->where('id', '=', $id)->get();
        if(count($user)){
            $response = [
                'success' => true,
                'result' => $user
            ];
            return response($response, 200);
        }else{
            $response = [
                'success' => false,
                'result' => 'No admin found.'
            ];
            return response($response, 400);
        }
    }
    function insertadmin(Request $request)
    {
        $rules = array(
            'username'=>'required',
            'name' => 'required',
            'mobile' => 'required|integer',
            'password'=>'required',
            'status' => 'required',
            'role' => 'required'
        );
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            $response = [
                'success' => false,
                'result' => $validator->errors()
            ];
            return response($response, 400);
        }else{
            $user = new User;
            $user->username = $request->username;
            $user->name = $request->name;
            $user->mobile = $request->mobile;
            $user->password = Hash::make($request->password);
            $user->status = $request->status;
            $user->type = 'Admin';
            $user->save();
            $response = [
                'success' => true,
                'result' => 'New admin registered'
            ];
            return response($response, 200);
        }
    }
    function inactiveadmin($id)
    {  
        $deleted = DB::table('users')
        ->where('id', $id)
        ->update(['status' => 'Inactive']);
        $response = [
            'success' => true,
            'result' => 'Admin Inactivated'
        ];
        return response($response, 200);
    }
    function activeadmin($id)
    {  
        $deleted = DB::table('users')
        ->where('id', $id)
        ->update(['status' => 'Active']);
        $response = [
            'success' => true,
            'result' => 'Admin activated'
        ];
        return response($response, 200);
    }
    /*function updateadmin(Request $request)
    {
        $rules = array(
            'username'=>'required',
            'name' => 'required',
            'mobile' => 'required|integer',
            'password'=>'required',
            'status' => 'required'
        );
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            $response = [
                'success' => false,
                'result' => $validator->errors()
            ];
            return response($response, 400);
        }else{
            $user = User::where([
                ['id', '=', $request->id]
            ])->get();
            if(count($user)){
                $affected = DB::table('users')
                ->where('id', $request->id)
                ->update(
                    ['username' => $request->username,
                    'name' => $request->name,
                    'mobile' => $request->mobile,
                    'password' => $request->id_proofe_type,
                    'status' => $request->status
                ]);
                $response = [
                    'success' => true,
                    'result' => 'Admin data updated'
                ];
                return response($response, 200);
            }else{
                $response = [
                    'success' => false,
                    'result' => "Data not found"
                ];
                return response($response, 400);
            }
        }
    }*/
}
