<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    
    public function index()
    {
        return Designation::latest()->get();
    }

   
    public function store(Request $request)
    {
        //validation

        $this->validate($request,[
            'position' => 'required | string | unique:designations',
            'description' => 'required | string'
        ]);

        $designation =  new Designation();
        $designation->position = $request->position;
        $designation->description = $request->description;

        if ($designation->saveOrFail()) {
            return response()->json([
                'status' => true,
                'message' => 'Designation was added successfully.'
            ]);
        }
    }

   
    public function update(Request $request, $id)
    {
        ////validation

        $this->validate($request,[
            'position' => 'required | string | unique:designations,position,'.$id,
            'description' => 'required | string'
        ]);

        $designation = Designation::findOrFail($id);
        $designation->position = $request->position;
        $designation->description = $request->description;

        if ($designation->saveOrFail()) {
            return response()->json([
                'status' => true,
                'message' => 'Designation was updated successfully.'
            ]);
        }


    }

    
    public function destroy($id)
    {
        $designation = Designation::findOrFail($id);

        if($designation->delete()) {
            return response()->json([
                'status' => true,
                'message' => 'Designation was deleted successfully.'
            ]);
        }
    }
}
