<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Position;
use App\Models\Department;

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
        return view('admin.projects');
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
}
