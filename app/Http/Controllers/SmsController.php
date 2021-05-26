<?php

namespace App\Http\Controllers;

use AfricasTalking\SDK\AfricasTalking;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Sms;
use Exception;
use Illuminate\Http\Request;

class SmsController extends Controller
{
   
    public function index()
    {
        return Sms::with('employee.user')->latest()->get();
    }

    
    public function store(Request $request)
    {
        //validation

        $this->validate($request, [
            'phonenumber' => 'required',
            'message' => 'required',
            'employee_id' => 'required | integer',
        ]);

        // Set your app credentials
        $username   = "cagimu";
        $apiKey     = "fe51f7502415618e00418c0f9a4e5f7627c2ffcc008d1aaa3320cfa7363b921e";
        $AT         = new AfricasTalking($username, $apiKey);
        $sms        = $AT->sms();

        $recipients = $request->phonenumber;
        $message    = $request->message;

        $from  = "HRM";

        try{
            $result = $sms->send([
                'to'      => $recipients,
                'message' => $message
            ]);

            if($result['status']=="success"){
                $sms = new Sms();
                $sms->employee_id = $request->employee_id;
                $sms->message = $message;

                if($sms->saveOrFail()) {
                    return response()->json([
                        'status'=> true,
                        'message' => 'SMS sent successfully'
                    ]);
                }
            }

        } catch (Exception $e) {
            return response()->json([
                'status'=> false,
                'message' => 'Unable to send message'
            ]);
        }

    }

    public function destroy($id)
    {
        $sms = Sms::findOrFail($id);
        if ($sms->delete()) {
            return response()->json([
                'status'=> true,
                'message' => 'SMS deleted successfully'
            ]);
        }
    }


    public function homeData () {
        $smses =  Sms::get()->count();
        $designations =  Designation::get()->count();
        $employees =  Employee::get()->count();

        return response()->json([
            'smses' => $smses,
            'designations' => $designations,
            'employees' => $employees
        ]);
    }
}
