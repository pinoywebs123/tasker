<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\NewUser;
use Mail;
use Carbon\Carbon;

class AuthController extends Controller
{
    
    public function login()
    {
        $unverified_users =  User::where('status_id',0)->get();
        foreach($unverified_users as $user)
        {
            if(now()->diffInDays($user->created_at) > 3)
            {
                $user->delete();
            }
        }
        return view('auth.login');
    }

    public function loginCheck(Request $request)
    {
        $validatedData = $request->validate([
            'username' => ['required', 'max:255'],
            'password' => ['required'],
            
        ]);

        if(Auth::attempt(['username'=> strtolower($validatedData['username']), 'password'=> $validatedData['password']]))
        {
            if(Auth::user()->status_id != 1)
            {
                return back()->with('error','Verify your account.Kindly Check your email or Spam');
            }

            if( Auth::user()->getRoleNames()[0] == 'admin')
            {
                return redirect()->route('admin_home');
            }else if( Auth::user()->getRoleNames()[0] == 'manager')
            {
                return redirect()->route('admin_projects');
            }else if( Auth::user()->getRoleNames()[0] == 'tasker')
            {
                return redirect()->route('tasker_home');
            }else if(Auth::user()->getRoleNames()[0] == 'manager_limited')
            {
                return redirect()->route('admin_projects');
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
            'first_name' => ['required'],
            'last_name' => ['required'],
            // 'position' => ['required'],
            'department' => ['required'],
            'password' => ['required','max:20'],
            'repeat_password' => ['required','same:password'],
        ]);

        $data = $request->all();

        $user = new User;

        if($data['user_type'] == 2)
        {
            $user->position_id      = 99;
            $user->department_id    = $validatedData['department'];
            $user->first_name       = strtolower($validatedData['first_name']);
            $user->last_name        = strtolower($validatedData['last_name']);
            $user->username         = strtolower($validatedData['first_name'].'.'.$validatedData['last_name']);
            $user->email            = $validatedData['email'];
            $user->password         = bcrypt($validatedData['password']);
            $user->status_id        = 0;
            $user->save();

            $user->assignRole('manager');
            
        }else if($data['user_type'] == 3)
        {
            $user->position_id      = $validatedData['position'];
            $user->department_id    = $validatedData['department'];
            $user->first_name       = strtolower($validatedData['first_name']);
            $user->last_name        = strtolower($validatedData['last_name']);
            $user->username         = strtolower($validatedData['first_name'].'.'.$validatedData['last_name']);
            $user->email            = $validatedData['email'];
            $user->password         = bcrypt($validatedData['password']);
            $user->status_id        = 0;
            $user->save();

            $user->assignRole('tasker');

        }else if($data['user_type'] == 4)
        {
            $user->position_id      = $validatedData['position'];
            $user->department_id    = $validatedData['department'];
            $user->first_name       = strtolower($validatedData['first_name']);
            $user->last_name        = strtolower($validatedData['last_name']);
            $user->username         = strtolower($validatedData['first_name'].'.'.$validatedData['last_name']);
            $user->email            = $validatedData['email'];
            $user->password         = bcrypt($validatedData['password']);
            $user->status_id        = 0;
            $user->save();

            $user->assignRole('manager_limited');

        }else if($data['user_type'] == 1)
        {
            $user->position_id      = 99;
            $user->department_id    = $validatedData['department'];
            $user->first_name       = strtolower($validatedData['first_name']);
            $user->last_name        = strtolower($validatedData['last_name']);
            $user->username         = strtolower($validatedData['first_name'].'.'.$validatedData['last_name']);
            $user->email            = $validatedData['email'];
            $user->password         = bcrypt($validatedData['password']);
            $user->status_id        = 0;
            $user->save();

            $user->assignRole('admin');

        }else {
            return 'Invalid User Type';
        }

        Mail::to($validatedData['email'])->send(new NewUser($validatedData, $user->id));

        return back()->with('success','Successfully Registered');

        
    }

    public function verifyAccount($email)
    {
         $check_user = User::where('email',$email)->update(['status_id' => 1]);
        if($check_user)
        {
            return redirect('/login')->with('success','Account Verified Successfully');
        }
    }
}
