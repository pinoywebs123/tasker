<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    public function login()
    {
        return view('auth.login');
    }

    public function loginCheck(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'max:255'],
            'password' => ['required'],
            
        ]);

        if(Auth::attempt($validatedData))
        {

            if( Auth::user()->getRoleNames()[0] == 'admin')
            {
                return redirect()->route('admin_home');
            }else if( Auth::user()->getRoleNames()[0] == 'manager')
            {
                return redirect()->route('admin_projects');
            }else if( Auth::user()->getRoleNames()[0] == 'tasker')
            {
                return redirect()->route('tasker_home');
            }
        }else 
        {
            return back()->with('error','Invalid Credentials');
        }
    }

    public function register()
    {
        return redirect()->route('login');
        // $positions = Position::all();
        // $departments = Department::all();

        // return view('auth.register',compact('positions','departments'));
    }

    public function registerCheck(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'unique:users', 'max:255'],
            'user_type' => ['required'],
            'name' => ['required'],
            'position' => ['required'],
            'department' => ['required'],
            'password' => ['required','max:20'],
            'repeat_password' => ['required','same:password'],
        ]);

        $data = $request->all();

        $user = new User;

        if($data['user_type'] == 1)
        {
            $user->position_id      = $validatedData['position'];
            $user->department_id    = $validatedData['department'];
            $user->name             = $validatedData['name'];
            $user->email            = $validatedData['email'];
            $user->password         = bcrypt($validatedData['password']);
            $user->save();

            $user->assignRole('manager');
            
        }else if($data['user_type'] == 2)
        {
            $user->position_id      = $validatedData['position'];
            $user->department_id    = $validatedData['department'];
            $user->name             = $validatedData['name'];
            $user->email            = $validatedData['email'];
            $user->password         = bcrypt($validatedData['password']);
            $user->save();

            $user->assignRole('tasker');

        }else {
            return 'Invalid User Type';
        }

        return back()->with('success','Successfully Registered');

        
    }
}
