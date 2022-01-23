<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class EmployeeController extends Controller
{
    //
    public function employee() {
        $data = "All Products";
        return response()->json($data, 200);
    }
 
    public function productAuth() {
        $data = "Product Owner: " . Auth::user()->name;
        return response()->json($data, 200);
    }
}
