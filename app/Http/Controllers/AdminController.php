<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function home()
    {
        $users = User::all();
        return view('admin.home',compact('users'));
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
}
