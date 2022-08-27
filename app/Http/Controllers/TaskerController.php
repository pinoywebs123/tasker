<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\Task;
use App\Models\Department;

class TaskerController extends Controller
{
    public function home()
    {
        $projects = DB::table('users')
                        ->join('project_departments','users.department_id','=','project_departments.department_id')
                        ->join('projects','project_departments.project_id','=','projects.id')
                        ->where('users.id', Auth::id())
                        ->select('projects.id','projects.title','projects.description','projects.status_id','projects.created_at')
                        ->get();

        $department_name = Department::find(Auth::user()->department_id);               

        return view('tasker.home',compact('projects','department_name'));
    }

    public function task_list($id)
    {
        $tasks = DB::table('tasks')
                ->join('project_departments','tasks.project_id','=','project_departments.project_id')
                ->where('tasks.project_id', $id)
                ->where('project_departments.department_id', Auth::user()->department_id)
                ->select('tasks.id','tasks.title','tasks.description','tasks.created_at','tasks.status_id')
                ->get();
        $department_name = Department::find(Auth::user()->department_id);        

        return view('tasker.task',compact('tasks','department_name'));        
    }

    public function update_task($id)
    {
        $find_task = Task::find($id);

        if(!$find_task)
        {
            return back()->with('error','Task Not Found');
        }

        $find_task->update(['status_id'=> 3]);

        return back()->with('success','Task is Completed.');
    }
}    
