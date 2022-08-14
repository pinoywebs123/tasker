<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\TaskerController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginCheck'])->name('login_check');
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'registerCheck'])->name('register');

Route::group(['prefix'=> 'admin','middleware'=> ['auth','role:admin']], function(){
    Route::get('/home',[AdminController::class, 'home'])->name('admin_home');
    Route::get('/logout',[AdminController::class, 'logout'])->name('admin_logout');

    
    Route::post('/find-user',[AdminController::class, 'findUser'])->name('admin_find_user');
    Route::post('/update-user',[AdminController::class, 'updateUser'])->name('admin_update_user');
    Route::post('/delete-user',[AdminController::class, 'deleteUser'])->name('admin_delete_user');


    Route::get('/projects',[AdminController::class, 'projects'])->name('admin_projects');
    Route::post('/projects',[AdminController::class, 'createProjects'])->name('admin_create_projects');
    Route::post('/change-projects',[AdminController::class, 'changeProjectStatus'])->name('admin_change_projects_status');
    Route::post('/find-project',[AdminController::class, 'findProjects'])->name('admin_find_projects');
    Route::post('/update-project',[AdminController::class, 'updateProjects'])->name('admin_update_projects');

});




