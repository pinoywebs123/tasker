<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class GanttController extends Controller
{
    public function get(){
    
 
        return response()->json([
            "data" => Task::all()
            
        ]);
    }
}
