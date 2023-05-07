<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Position;
use App\Models\Project;
use App\Models\Task;
use App\Models\SubTask;
use App\Models\TaskFile;
use App\Models\Assign;
use App\Models\ReportType;
use App\Models\FileType;
use App\Models\Comment;
use App\Models\TaskFirstFolder;

use App\Models\Department;
use App\Models\ProjectDepartment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use File;

class AdminController extends Controller
{

    public function home()
    {
        $positions = Position::all();
        $departments = Department::all();
        $users = User::where('status_id',1)->get();
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

        if(Auth::user()->getRoleNames()[0] == 'manager')
        {
             $project_department = new Collection(DB::table('users')
                        ->join('project_departments','users.department_id','=','project_departments.department_id')
                        ->join('projects','project_departments.project_id','=','projects.id')
                        ->join('departments','project_departments.department_id','=','departments.id')
                        ->where('users.id', Auth::id())
                        ->where('projects.status_id', '!=', 0)
                        ->select('projects.id','projects.title','projects.description','projects.status_id','projects.created_at','projects.user_id','projects.project_type','projects.deadline','departments.name as department_name')
                        ->get());

            $projects_created = new Collection(Project::where('user_id', Auth::id())->select('projects.id','projects.title','projects.description','projects.status_id','projects.created_at','projects.user_id','projects.project_type','projects.deadline')->get());

             

            $projects =  $projects_created->merge($project_department);

           
        }else
        {
               $projects = Project::where('status_id',1)->orWhere('status_id',2)
                        ->join('project_departments','projects.id','=','project_departments.project_id')
                        ->join('departments','project_departments.department_id','=','departments.id')
                        ->select('projects.id','projects.status_id','projects.created_at','projects.project_type','projects.deadline','projects.title','departments.name as department_name')
                        ->get();
        }

        $report_types = ReportType::all();
        
        return view('admin.projects',compact('projects','departments','report_types'));
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

    public function restore_projects($id)
    {
        $find = Project::find($id);
        if($find)
        {
            $find->update(['status_id'=> 1]);
            return back()->with('success','Project Restore Successfully');
        }
    }

    public function findUser(Request $request)
    {
        return response()->json(User::find($request->user_id));
    }

    public function updateUser(Request $request)
    {
        $find_user = User::find($request->user_id);

        if($request->password == null){
            $find_user->position_id     = 99;
            $find_user->department_id   = $request->department;
            $find_user->first_name      = $request->first_name;
            $find_user->last_name       = $request->last_name;
            $find_user->email           = $request->email;
            $find_user->username        = strtolower($request->first_name.'.'.$request->last_name);
        }else 
        {
            $find_user->position_id     = 99;
            $find_user->department_id   = $request->department;
            $find_user->first_name      = $request->first_name;
            $find_user->last_name       = $request->last_name;
            $find_user->email           = $request->email;
            $find_user->password        = bcrypt($request->password);
            $find_user->username        = strtolower($request->first_name.'.'.$request->last_name);
             
        }

        $find_user->save();
        
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
        $proj->department_id  = $request->department_id;
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
        }else if($find_project->status_id == 2)
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
        $file_types = FileType::all();

        if(@$_GET['arrange_by'] == 'Normal')
        {
            return view('admin.tasks',compact('find_project','tasks','departments','find_assign_project','file_types'));

        }else if(@$_GET['arrange_by'] == 'Sub-Task')
        {
            return view('admin.tasks_sub',compact('find_project','tasks','departments','find_assign_project','file_types'));

        }

        return view('admin.tasks',compact('find_project','tasks','departments','find_assign_project','file_types'));

        
    }

    public function create_task(Request $request)
    {

        $path = public_path($request->title.'/');

        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);

        }

       if(isset($request->task_file))
       {
            $cover = $request->file('task_file')->getClientOriginalName();
            $file_size = $request->file('task_file')->getSize();
       
            $url = Storage::putFileAs('public', $request->file('task_file'),$cover);
       }else {
        $url = 'null';
        $file_size = 'null';
       }

       

        $task = new Task;
        $task->project_id   = $request->project_id;
        $task->status_id    = 1;
        $task->title        = $request->title;
        $task->description  = $request->description;
        $task->deadline     = $request->deadline;
        $task->updated_by   = Auth::id();
        $task->save();

        $task_file = new TaskFile;
        $task_file->task_id     = $task->id;
        $task_file->user_id     = Auth::id();
        $task_file->file_name   = $url;
        $task_file->type     = $request->file_type;
        $task_file->size     =$file_size;
        $task_file->save();

        $new_folder = new TaskFirstFolder;
        $new_folder->task_id = $task->id;
        $new_folder->user_id = Auth::id();
        $new_folder->folder_name = $request->title;
        $new_folder->save();

        
        return back()->with('success','Task Created Successfully');
    }

    public function folders()
    {
        $folders = TaskFirstFolder::where('user_id',Auth::id())->get();
        return view('admin.folders',compact('folders'));
    }

    public function folders_files($id)
    {
        $folder_files = TaskFile::where('task_id',$id)->where('user_id',Auth::id())->where('size','!=','null')->get();
        return view('admin.folder_files',compact('folder_files'));
    }

    public function create_sub_task(Request $request)
    {
        if(isset($request->task_file))
       {
            $cover = $request->file('task_file')->getClientOriginalName();;
       
            $url = Storage::putFileAs('public', $request->file('task_file'),$cover);
       }else {
        $url = 'null';
       }

        $task = new SubTask;
        $task->task_id   = $request->task_id;
        $task->status_id    = 1;
        $task->title        = $request->title;
        $task->description  = $request->description;
        $task->deadline     = $request->deadline;
        $task->updated_by   = Auth::id();
        $task->save();

        return back()->with('success','Sub Task Created Successfully');
    }

    public function findTask(Request $request)
    {
        $find_task = Task::find($request->task_id);
        return response()->json( $find_task );
    }

    public function findSubTask(Request $request)
    {
        $find_sub = SubTask::find($request->sub_id);
        return response()->json( $find_sub );
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
            'description'   => $request->description,
            'deadline'      => $request->deadline,
            'updated_by'    => Auth::id()
        ]);

        return back()->with('success','Task Updated Successfully');
    }

    public function updateSubTask(Request $request)
    {

        $find_task = SubTask::find($request->sub_id);

        if(!$find_task)
        {
            return back()->with('error','SubTask Not Found');
        }

        $find_task->update([
            'title'         => $request->title, 
            'description'   => $request->description,
            'deadline'      => $request->deadline,
            'updated_by'    => Auth::id()
        ]);

        return back()->with('success','SubTask Updated Successfully');
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

    public function changeSubTasktStatus(Request $request)
    {
        $find_task = SubTask::find($request->sub_id);

        if(!$find_task)
        {
            return back()->with('error','SubTask Not Found');
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

    public function deleteTask(Request $request)
    {
        $find_task = Task::find($request->task_id);

        if(!$find_task)
        {
            return back()->with('error','Task Not Found');
        }

        $find_task->delete();
        return back()->with('success','Task deleted Successfully');

    }

    public function deleteSubTask(Request $request)
    {
        $find_task = SubTask::find($request->sub_id);

        if(!$find_task)
        {
            return back()->with('error','SubTask Not Found');
        }

        $find_task->delete();
        return back()->with('success','SubTask deleted Successfully');

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
        Task::where('project_id', $find_project->id)->update(['status_id'=>2]);
        return back()->with('success', 'Project '.$find_project->title.' Completed Successfully');
    }

    public function system_maintenance()
    {
        $roles = DB::table('roles')->get();
        $departments = Department::all();
        $positions = Position::all();
        $report_types = ReportType::all();
        $file_types = FileType::all();

        return view('admin.maintenance',compact('roles','departments','positions','report_types','file_types'));
    }

    public function createDepartment(Request $request)
    {
       Department::create(['name'=> $request->name]);
       return back()->with('success', 'Department Created Successfully');
    }

    public function createPosition(Request $request)
    {
        Position::create(['name'=> $request->name]);
        return back()->with('success', 'Department Created Successfully');
    }

    public function delete_department($id)
    {
        Department::where('id', $id)->delete();
        return back()->with('success', 'Department Deleted Successfully');
    }

    public function delete_position($id)
    {
        Position::where('id', $id)->delete();
        return back()->with('success', 'Position Deleted Successfully');
    }

    public function assignUser(Request $request)
    {
        Assign::create($request->all());
        return back()->with('success', 'Assigned Successfully');
    }

    public function department_create(Request $request)
    {
        
        $get_positions = DB::table('assigns')
                        ->join('positions','positions.id','=','assigns.position_id')
                        ->where('assigns.department_id', $request->department_id)
                        ->select('assigns.id as id','assigns.position_id as position_id','positions.name as position_name')
                        ->get();

        return response()->json($get_positions);
    }

    public function position_create(Request $request)
    {
        $get_roles = DB::table('assigns')
                        ->join('roles','roles.id','=','assigns.role_id')
                        ->where('assigns.department_id', $request->department_id)
                        ->where('assigns.position_id', $request->position_id)
                        ->select('assigns.id as id','assigns.role_id as role_id','roles.name as role_name')
                        ->first();

        return response()->json($get_roles);
    }

    public function createReportType(Request $request)
    {

        ReportType::create(['name'=> $request->name]);
        return back()->with('success', 'Report Type Created Successfully');
    }

    public function deleteReportType($id)
    {
        ReportType::where('id', $id)->delete();
        return back()->with('success', 'Report Type Deleted Successfully');
    }

    public function createFileType(Request $request)
    {
        FileType::create(['name'=> $request->name]);
        return back()->with('success', 'File Type Created Successfully');
    }

    public function deleteFileType($id)
    {
        FileType::where('id', $id)->delete();
        return back()->with('success', 'File Type Deleted Successfully');
    }

    public function task_file_list($id)
    {
       $find_project = Project::find($id);
       

        if(!$find_project)
        {
            return abort(404);
        }

       $find_assign_project = ProjectDepartment::where('project_id',$id)->first();
        $tasks = Task::where('project_id', $id)->with('task_files')->get();

        return view('admin.tasks_files',compact('find_project','find_assign_project','tasks'));
    }

    public function task_schedule_list($id)
    {
        $find_project = Project::find($id);

        if(!$find_project)
        {
            return abort(404);
        }

        $tasks = Task::where('project_id', $id)->get();



       $find_assign_project = ProjectDepartment::where('project_id',$id)->first();

        return view('admin.tasks_schedules',compact('find_project','find_assign_project','tasks'));
    }

    public function task_timeline_list($id)
    {
        $find_project = Project::find($id);

        if(!$find_project)
        {
            return abort(404);
        }

        $tasks = Task::where('project_id', $id)->get();

        $comments = Comment::orderBy('id','desc')->with('user')->get();
        $task_files = TaskFile::where('file_name','!=','null')->with('user')->get();

       $find_assign_project = ProjectDepartment::where('project_id',$id)->first();

        return view('admin.tasks_timeline',compact('find_project','find_assign_project','tasks','comments','task_files'));
    }

    public function user_settings()
    {
        return view('admin.user_settings');
    }

    public function user_settings_check(Request $request)
    {
        $this->validate($request, [
            'password' => 'min:6',
            'repeat_password' => 'required_with:password|same:password|min:6'
        ]);
        
        $find_user = User::find(Auth::id());
        $find_user->update([
            'password'=> bcrypt($request->password)
        ]);

        return back()->with('success', 'Password Updated Successfully');
    }

    public function createFaculty(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'unique:users', 'max:255'],
            //'user_type' => ['required'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            // 'position' => ['required'],
            //'department' => ['required'],
            'password' => ['required','max:20'],
            'repeat_password' => ['required','same:password'],
        ]);


        $user = new User;

        $user->position_id      = 99;
        $user->department_id    = Auth::user()->department_id;
        $user->first_name       = strtolower($validatedData['first_name']);
        $user->last_name        = strtolower($validatedData['last_name']);
        $user->username         = strtolower($validatedData['first_name'].'.'.$validatedData['last_name']);
        $user->email            = $validatedData['email'];
        $user->password         = bcrypt($validatedData['password']);
        $user->status_id        = 0;
        $user->save();

        $user->assignRole('tasker');

        return back()->with('success', 'User Created Successfully');

    }

    public function delete_all_projects(Request $request)
    {
        $find = Project::find($request->project_id);
        if( $find )
        {
            Task::where('project_id',$find->id)->delete();
            $find->delete();

            return back()->with('success', 'Project and other data related has been Deleted Successfully');
        }
    }
}
