<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Position;
use App\Models\Project;
use App\Models\Task;

use App\Models\Department;
use App\Models\ProjectDepartment;


class AdminController extends Controller
{
    public function home()
    {
        $positions = Position::all();
        $departments = Department::all();
        $users = User::all();
        return view('admin.home',compact('users','positions','departments'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function projects()
    {
        $departments = Department::all();
        $projects = Project::all();
        return view('admin.projects',compact('projects','departments'));
    }

    public function findUser(Request $request)
    {
        return response()->json(User::find($request->user_id));
    }

    public function updateUser(Request $request)
    {
        $find_user = User::find($request->user_id);

        if($request->password == null){
            $find_user->position_id     = $request->position;
            $find_user->department_id   = $request->department;
            $find_user->name            = $request->name;
            $find_user->email           = $request->email;
            $find_user->save();
        }else 
        {
            $find_user->position_id     = $request->position;
            $find_user->department_id   = $request->department;
            $find_user->name            = $request->name;
            $find_user->email           = $request->email;
            $find_user->password        = bcrypt($request->password);
            $find_user->save(); 
        }

        return back()->with('success','Updated Successfully');
            
    }

    public function deleteUser(Request $request)
    {
        $find_user = User::find($request->user_id);
        if($find_user)
        {
            $find_user->delete();
        }

        return back()->with('success','Deleted Successfully');
    }

    public function createProjects(Request $request)
    {
        $proj = new Project;
        $proj->user_id      = Auth::id();
        $proj->status_id    = 1;
        $proj->title        = $request->title;
        $proj->description  = $request->description;
        $proj->save();
       
        return back()->with('success','Created Successfully');
    }

    public function changeProjectStatus(Request $request)
    {
        $find_project = Project::find($request->project_id);

        if(!$find_project)
        {
            return back()->with('error','Project Not Found');
        }

        if($find_project->status_id == 1)
        {
            $status_id = 0;
        }else if($find_project->status_id == 0)
        {
            $status_id = 1;
        }

        $find_project->update(['status_id'=> $status_id]);

        return back()->with('success','Status Updated Successfully');
    }

    public function findProjects(Request $request)
    {
        $find_project = Project::find($request->project_id);
        return response()->json( $find_project );
    }

    public function updateProjects(Request $request)
    {
        $find_project = Project::find($request->project_id);

        if(!$find_project)
        {
            return back()->with('error','Project Not Found');
        }

        $find_project->update([
            'title'         => $request->title, 
            'description'   => $request->description
        ]);

        return back()->with('success','Project Updated Successfully');
    }

    public function task_list($id)
    {
        $find_project = Project::find($id);

        if(!$find_project)
        {
            return abort(404);
        }

        $tasks = Task::where('project_id', $id)->get();
        $departments = Department::all();
        $find_assign_project = ProjectDepartment::where('project_id',$id)->first();

        return view('admin.tasks',compact('find_project','tasks','departments','find_assign_project'));
    }

    public function create_task(Request $request)
    {
        
        $task = new Task;
        $task->project_id   = $request->project_id;
        $task->status_id    = 1;
        $task->title        = $request->title;
        $task->description  = $request->description;
        $task->save();
        
        return back()->with('success','Task Created Successfully');
    }

    public function findTask(Request $request)
    {
        $find_task = Task::find($request->task_id);
        return response()->json( $find_task );
    }

    public function updateTask(Request $request)
    {

        $find_task = Task::find($request->task_id);

        if(!$find_task)
        {
            return back()->with('error','Task Not Found');
        }

        $find_task->update([
            'title'         => $request->title, 
            'description'   => $request->description
        ]);

        return back()->with('success','Task Updated Successfully');
    }

    public function changeTasktStatus(Request $request)
    {
        $find_task = Task::find($request->task_id);

        if(!$find_task)
        {
            return back()->with('error','Task Not Found');
        }

        if($find_task->status_id == 1)
        {
            $status_id = 0;
        }else if($find_task->status_id == 0)
        {
            $status_id = 1;
        }

        $find_task->update(['status_id'=> $status_id]);

        return back()->with('success','Status Updated Successfully');
    }

    public function assignProject(Request $request)
    {
        $assign = new ProjectDepartment;
        $assign->project_id     = $request->project_id;
        $assign->department_id  = $request->department_id;
        $assign->user_id        = Auth::id(); //created_by
        $assign->save();
        
        return back()->with('success','Project Assigned Successfully');
    }

    public function assignTask(Request $request)
    {
        return $request->all();
    }
}
