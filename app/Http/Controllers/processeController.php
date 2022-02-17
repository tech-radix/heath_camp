<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Processe;
use Illuminate\Support\Facades\DB;
use Validator;

class processeController extends Controller
{
    //
    function showprocesses(Request $request)
    {
        $processe = Processe::all()->toArray();
        $response = [
            'success' => true,
            'result' => $processe
        ];
        return response($response, 200);
    }
    function showprocess($process_id)
    {  
        $processe = Processe::where([
            ['process_id', '=', $process_id]
        ])->get();
        if(count($processe)){
            $response = [
                'success' => true,
                'result' => $processe
            ];
            return response($response, 200);
        }else{
            $response = [
                'success' => false,
                'result' => 'No process found.'
            ];
            return response($response, 400);
        }
    }
    function insertprocess(Request $request)
    {
        $rules = array(
            'user_id'=>'required|integer',
            'doctor_id'=>'required|integer',
            'pre_prescription' => 'required',
            'post_priscription' => 'required',
            'patho_report'=>'required',
            'process_status' => 'required'
        );
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            $response = [
                'success' => false,
                'result' => $validator->errors()
            ];
            return response($response, 400);
        }else{
            $process = new Processe;
            $process->user_id = $request->user_id;
            $process->doctor_id = $request->doctor_id;
            $process->pre_prescription = $request->pre_prescription;
            $process->post_priscription = $request->post_priscription;
            $process->patho_report = $request->patho_report;
            $process->process_status = $request->process_status;
            $process->save();
            $response = [
                'success' => true,
                'result' => 'New process registered'
            ];
            return response($response, 200);
        }
    }
    function updateprocess(Request $request)
    {
        $rules = array(
            'user_id'=>'required|integer',
            'doctor_id'=>'required|integer',
            'pre_prescription' => 'required',
            'post_priscription' => 'required',
            'patho_report'=>'required',
            'process_status' => 'required',
            'process_id' => 'required|integer'
        );
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            $response = [
                'success' => false,
                'result' => $validator->errors()
            ];
            return response($response, 400);
        }else{
            $process = Processe::where([
                ['process_id', '=', $request->process_id]
            ])->get();
            if(count($process)){
                $affected = DB::table('processes')
                ->where('process_id', $request->process_id)
                ->update(
                    ['user_id' => $request->user_id,
                    'doctor_id' => $request->doctor_id,
                    'pre_prescription' => $request->pre_prescription,
                    'post_priscription' => $request->post_priscription,
                    'process_status' => $request->process_status,
                    'patho_report' => $request->patho_report,
                ]);
                $response = [
                    'success' => true,
                    'result' => 'Process data updated'
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
    function deleteprocess($process_id)
    {  
        $deleted = DB::table('processes')->where('process_id', '=', $process_id)->delete();
        $response = [
            'success' => true,
            'result' => 'Process data deleted'
        ];
        return response($response, 200);
    }
}
