<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{

    public function index()
    {
        return Employee::with(['user', 'designation'])->latest()->get();
    }


    public function store(Request $request)
    {
        //validation
        $this->validate($request, [
            'designation_id' => 'required | integer | min:1',
            'phonenumber' => 'required | string | min:13 | max:13 | unique:employees',
            'duty_type' => 'required | string',

            'name' => 'required | string | min:5 | max:50',
            'email' => 'required | string | unique:users',
            'photo' => 'required | file | image'
        ]);

        // Upload photo

        $photoFile = $request->file('photo');
        $fileName = $photoFile->getClientOriginalName();

        $photoPath = $photoFile->storeAs('photos', $fileName, 'public');

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->photo = $photoPath;
        $user->password = Hash::make($request->name);

        if ($user->saveOrFail()) {
            $employee = new Employee();
            $employee->user_id = $user->id;
            $employee->designation_id = $request->designation_id;
            $employee->phonenumber = $request->phonenumber;
            $employee->duty_type = $request->duty_type;

            if ($employee->saveOrFail()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Employee was created successfully.'
                ]);
            }
        }
    }


    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $user = User::findOrFail($employee->user_id);

        //validation
        $this->validate($request, [
            'designation_id' => 'required | integer | min:1',
            'phonenumber' => 'required | string | min:13 | max:13 | unique:employees,phonenumber,'.$id,
            'duty_type' => 'required | string',

            'name' => 'required | string | min:5 | max:50',
            'email' => 'required | string | unique:users,email,' . $user->id,
            'photo' => ' sometimes | nullable | file | image'
        ]);

        

        if ($request->hasFile('photo')) {
            $photoFile = $request->file('photo');
            $fileName = $photoFile->getClientOriginalName();
            $photoPath = $photoFile->storeAs('photos', $fileName, 'public');
        } else {
            $photoPath = $user->photo;
        }


        $user->name = $request->name;
        $user->email = $request->email;
        $user->photo = $photoPath;
        $user->password = Hash::make($request->name);

        if ($user->saveOrFail()) {
            $employee->user_id = $user->id;
            $employee->designation_id = $request->designation_id;
            $employee->phonenumber = $request->phonenumber;
            $employee->duty_type = $request->duty_type;

            if ($employee->saveOrFail()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Employee was updated successfully.'
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        if ($employee->delete()) {
            return response()->json([
                'status' => true,
                'message' => 'Employee was deleted successfully.'
            ]);
        }
    }
}
