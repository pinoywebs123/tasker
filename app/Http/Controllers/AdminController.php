<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Position;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskFile;

use App\Models\Department;
use App\Models\ProjectDepartment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

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

        if(Auth::user()->getRoleNames()[0] == 'manager_limited')
        {
             $project_department = new Collection(DB::table('users')
                        ->join('project_departments','users.department_id','=','project_departments.department_id')
                        ->join('projects','project_departments.project_id','=','projects.id')
                        ->where('users.id', Auth::id())
                        ->where('projects.status_id', '!=', 0)
                        ->select('projects.id','projects.title','projects.description','projects.status_id','projects.created_at','projects.user_id')
                        ->get());

            $projects_created = new Collection(Project::where('user_id', Auth::id())->select('projects.id','projects.title','projects.description','projects.status_id','projects.created_at','projects.user_id')->get());

             

            $projects =  $projects_created->merge($project_department);

           
        }else
        {
            $projects = Project::where('status_id',1)->orWhere('status_id',2)->get();
        }
        
        return view('admin.projects',compact('projects','departments'));
    }

    public function archive_projects()
    {
        if(Auth::user()->getRoleNames()[0] == 'manager_limited')
        {
            $projects = Project::where('status_id', 0)->where('user_id',Auth::id())->get();
        }else{
            $projects = Project::where('status_id', 0)->get();
        }
        
        return view('admin.archive_projects',compact('projects'));
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
        $proj->user_id        = Auth::id();
        $proj->status_id      = 1;
        $proj->title          = $request->title;
        $proj->deadline       = $request->deadline;
        $proj->project_type   = $request->project_type;
        $proj->description    = $request->description;
        $proj->save();

        $this->assignProject($proj->id, $request->department_id);
       
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


       if(isset($request->task_file))
       {
            $cover = $request->file('task_file')->getClientOriginalName();;
       
            $url = Storage::putFileAs('public', $request->file('task_file'),$cover);
       }else {
        $url = 'null';
       }

        $task = new Task;
        $task->project_id   = $request->project_id;
        $task->status_id    = 1;
        $task->title        = $request->title;
        $task->description  = $request->description;
        $task->deadline     = $request->deadline;
        $task->save();

        $task_file = new TaskFile;
        $task_file->task_id     = $task->id;
        $task_file->user_id     = Auth::id();
        $task_file->file_name   = $url;
        $task_file->save();

        
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

    public function assignProject($project_id, $department_id)
    {
        $check_assign = ProjectDepartment::where('project_id',$project_id)->where('department_id',$department_id)->first();
        if($check_assign)
        {
          return back()->with('error','Project Already Assigned in this departments');  
        }
        $assign = new ProjectDepartment;
        $assign->project_id     = $project_id;
        $assign->department_id  = $department_id;
        $assign->user_id        = Auth::id(); //created_by
        $assign->save();
        
        return back()->with('success','Project Assigned Successfully');
    }

    public function assignTask(Request $request)
    {
        return $request->all();
    }

    public function completedProject(Request $request)
    {
        $find_project = Project::find($request->project_id);
        if(!$find_project)
        {
            return back()->with('error', 'Project Does not exist');
        }

        $find_project->update(['status_id'=> 2]);
        return back()->with('success', 'Project '.$find_project->title.' Completed Successfully');
    }
}
