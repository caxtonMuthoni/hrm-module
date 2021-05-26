<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    
    public function index()
    {
        return Salary::with('employee.user')->latest()->get();
    }

    
    public function store(Request $request)
    {
        //validation
        $this->validate($request, [
            'employee_id' => 'required | integer | min:1',
            'employee_salary' => 'required | min:1000 | integer' 
        ]);

        $salary = new Salary();
        $salary->employee_id = $request->employee_id;
        $salary->employee_salary = $request->employee_salary;

        if($salary->saveOrFail()) {
            return response()->json([
                'status' => true,
                'message' => 'Employee salary was added successfully.'
            ]);
        }
    }

    
    public function update(Request $request, $id)
    {
         //validation
         $this->validate($request, [
            'employee_id' => 'required | integer | min:1 | unique:salaries,employee_id,'.$id,
            'employee_salary' => 'required | min:1000 | integer' 
        ]);

        $salary = Salary::findOrFail($id);
        $salary->employee_id = $request->employee_id;
        $salary->employee_salary = $request->employee_salary;

        if($salary->saveOrFail()) {
            return response()->json([
                'status' => true,
                'message' => 'Employee salary was updated successfully.'
            ]);
        }
    }

   
    public function destroy($id)
    {
        $salary = Salary::findOrFail($id);
        if ($salary->delete()) {
            return response()->json([
                'status' => true,
                'message' => 'Employee salary was deleted successfully.'
            ]);
        }
    }
}
