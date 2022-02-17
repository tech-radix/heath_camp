<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Camp;
use Illuminate\Support\Facades\DB;
use Validator;

class campcontroller extends Controller
{
    //
    function showcamps(Request $request)
    {
        $camp = Camp::all()->toArray();
        $response = [
            'success' => true,
            'result' => $camp
        ];
        return response($response, 200);
    }
    function showcamp($camp_id)
    {  
        $camp = Camp::where([
            ['camp_id', '=', $camp_id]
        ])->get();
        if(count($camp)){
            $response = [
                'success' => true,
                'result' => $camp
            ];
            return response($response, 200);
        }else{
            $response = [
                'success' => false,
                'result' => 'No camp found.'
            ];
            return response($response, 400);
        }
    }
    function insertcamps(Request $request)
    {
        $rules = array(
            'admin_id'=>'required|integer',
            'camp_name' => 'required',
            'camp_location' => 'required',
            'camp_city'=>'required',
            'camp_state' => 'required',
            'camp_status' => 'required'
        );
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            $response = [
                'success' => false,
                'result' => $validator->errors()
            ];
            return response($response, 400);
        }else{
            $camp = new Camp;
            $camp->admin_id = $request->admin_id;
            $camp->camp_name = $request->camp_name;
            $camp->camp_location = $request->camp_location;
            $camp->camp_city = $request->camp_city;
            $camp->camp_state = $request->camp_state;
            $camp->camp_status = $request->camp_status;
            $camp->save();
            $response = [
                'success' => true,
                'result' => 'New camp registered'
            ];
            return response($response, 200);
        }
    }
    function updatecamp(Request $request)
    {
        $rules = array(
            'admin_id'=>'required|integer',
            'camp_name' => 'required',
            'camp_location' => 'required',
            'camp_city'=>'required',
            'camp_state' => 'required',
            'camp_status' => 'required',
            'camp_id' => 'required|integer'
        );
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            $response = [
                'success' => false,
                'result' => $validator->errors()
            ];
            return response($response, 400);
        }else{
            $camp = Camp::where([
                ['camp_id', '=', $request->camp_id]
            ])->get();
            if(count($camp)){
                $affected = DB::table('camps')
                ->where('camp_id', $request->camp_id)
                ->update(
                    ['admin_id' => $request->admin_id,
                    'camp_name' => $request->camp_name,
                    'camp_location' => $request->camp_location,
                    'camp_city' => $request->camp_city,
                    'camp_state' => $request->camp_state,
                    'camp_status' => $request->camp_status,
                ]);
                $response = [
                    'success' => true,
                    'result' => 'Camp data updated'
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
    function deletecamp($camp_id)
    {  
        $deleted = DB::table('camps')->where('camp_id', '=', $camp_id)->delete();
        $response = [
            'success' => true,
            'result' => 'Camp data deleted'
        ];
        return response($response, 200);
    }
}
