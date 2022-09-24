<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\Task;
use App\Models\Department;
use App\Models\Comment;
use Illuminate\Support\Facades\Storage;

class ManagerController extends Controller
{
    public function home()
    {
      $projects = DB::table('users')
                        ->join('project_departments','users.department_id','=','project_departments.department_id')
                        ->join('projects','project_departments.project_id','=','projects.id')
                        ->where('users.id', Auth::id())
                        ->where('projects.status_id', '!=', 0)
                        ->select('projects.id','projects.title','projects.description','projects.status_id','projects.created_at')
                        ->get();

        $department_name = Department::find(Auth::user()->department_id);               

        return view('limited.home',compact('projects','department_name'));  
    }
    
}
