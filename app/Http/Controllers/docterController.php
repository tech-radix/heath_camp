<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docter;
use Illuminate\Support\Facades\DB;
use Validator;

class docterController extends Controller
{
    //
    function showdocters(Request $request)
    {
        $docter = Docter::all();
        if(count($docter)){
            $response = [
                'success' => true,
                'result' => $docter
            ];
            return response($response, 200);
        }else{
            $response = [
                'success' => false,
                'result' => 'No docter found.'
            ];
            return response($response, 400);
        }
    }
    function showdocter($docter_id)
    {  
        $docter = Docter::where([
            ['doctor_id', '=', $docter_id]
        ])->get();
        if(count($docter)){
            $response = [
                'success' => true,
                'result' => $docter
            ];
            return response($response, 200);
        }else{
            $response = [
                'success' => false,
                'result' => 'No docter found.'
            ];
            return response($response, 400);
        }
    }
    function insertdocters(Request $request)
    {
        $rules = array(
            'name'=>'required',
            'registrationno' => 'required',
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
            $docter = new Docter;
            $docter->doctor_name = $request->name;
            $docter->registration_no = $request->registrationno;
            $docter->doctor_status = $request->status;
            $docter->save();
            $response = [
                'success' => true,
                'result' => 'New docter registered'
            ];
            return response($response, 200);
        }
    }
    function updatedocter(Request $request)
    {
        $rules = array(
            'name'=>'required',
            'registrationno' => 'required',
            'status' => 'required',
            'docter_id' => 'required|integer'
        );
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            $response = [
                'success' => false,
                'result' => $validator->errors()
            ];
            return response($response, 400);
        }else{
            $docter = Docter::where([
                ['doctor_id', '=', $request->docter_id]
            ])->get();
            if(count($docter)){
                $affected = DB::table('Docters')
                ->where('doctor_id', $request->docter_id)
                ->update(['doctor_name' => $request->name,'registration_no' => $request->registrationno,'doctor_status' => $request->status]);
                $response = [
                    'success' => true,
                    'result' => 'Docter data updated'
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
    function deletedocter($docter_id)
    {  
        $deleted = DB::table('docters')->where('doctor_id', '=', $docter_id)->delete();
        $response = [
            'success' => true,
            'result' => 'Docter data deleted'
        ];
        return response($response, 200);
    }
}
