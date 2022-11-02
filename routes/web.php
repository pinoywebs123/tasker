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

Route::group(['prefix'=> 'admin','middleware'=> ['auth']], function(){

    
    Route::get('/home',[AdminController::class, 'home'])->name('admin_home');
    Route::get('/logout',[AdminController::class, 'logout'])->name('admin_logout');

    
    Route::post('/find-user',[AdminController::class, 'findUser'])->name('admin_find_user');
    Route::post('/update-user',[AdminController::class, 'updateUser'])->name('admin_update_user');
    Route::post('/delete-user',[AdminController::class, 'deleteUser'])->name('admin_delete_user');

    //project
    Route::get('/projects',[AdminController::class, 'projects'])->name('admin_projects');
    Route::get('/archive-projects',[AdminController::class, 'archive_projects'])->name('admin_archive_projects');
    Route::post('/projects',[AdminController::class, 'createProjects'])->name('admin_create_projects');
    Route::post('/change-projects',[AdminController::class, 'changeProjectStatus'])->name('admin_change_projects_status');
    Route::post('/completed-projects',[AdminController::class, 'completedProject'])->name('admin_completed_project');
    Route::post('/find-project',[AdminController::class, 'findProjects'])->name('admin_find_projects');
    Route::post('/update-project',[AdminController::class, 'updateProjects'])->name('admin_update_projects');

    //task
    Route::get('/{id}/task-list',[AdminController::class, 'task_list'])->name('admin_task_list');
    Route::post('create-task',[AdminController::class, 'create_task'])->name('admin_create_task');

    //Ajax
    Route::post('department-create',[AdminController::class, 'department_create'])->name('admin_department_create');
    Route::post('position-create',[AdminController::class, 'position_create'])->name('admin_position_create');


    Route::post('/find-task',[AdminController::class, 'findTask'])->name('admin_find_task');
    Route::post('/update-task',[AdminController::class, 'updateTask'])->name('admin_update_task');
    Route::post('/change-task',[AdminController::class, 'changeTasktStatus'])->name('admin_change_task_status');
    Route::post('/assign-project',[AdminController::class, 'assignProject'])->name('admin_assign_project');
    Route::post('/assign-task',[AdminController::class, 'assignTask'])->name('admin_assign_task');
    Route::post('/delete-task',[AdminController::class, 'deleteTask'])->name('admin_delete_task');

    //system maintenance
    Route::get('/system-maintenance',[AdminController::class, 'system_maintenance'])->name('admin_system_maintenance');
    Route::post('/create-department',[AdminController::class, 'createDepartment'])->name('admin_create_department');
    Route::post('/create-position',[AdminController::class, 'createPosition'])->name('admin_create_position');
    Route::get('/delete-department/{id}',[AdminController::class, 'delete_department'])->name('admin_delete_department');
    Route::get('/delete-position/{id}',[AdminController::class, 'delete_position'])->name('admin_delete_position');
    Route::post('/assign-user-type',[AdminController::class, 'assignUser'])->name('admin_assign_user');

    //file types
    Route::post('/create-report-type',[AdminController::class, 'createReportType'])->name('admin_create_report_type');
    Route::get('/delete-report-type/{id}',[AdminController::class, 'deleteReportType'])->name('admin_delete_report_type');

    //upload file type
    Route::post('/create-file-type',[AdminController::class, 'createFileType'])->name('admin_create_file_type');
    Route::get('/delete-file-type/{id}',[AdminController::class, 'deleteFileType'])->name('admin_delete_file_type');


});

Route::group(['prefix'=> 'tasker','middleware'=> 'role:tasker'], function(){

    //tasker
    Route::get('/home',[TaskerController::class, 'home'])->name('tasker_home');
    Route::get('/{id}/task-list',[TaskerController::class, 'task_list'])->name('tasker_task_list');
    Route::get('/{id}/update-task',[TaskerController::class, 'update_task'])->name('tasker_update_task');

});


Route::group(['prefix'=> 'tasker','middleware'=> 'auth'], function(){

    //tasker
    Route::get('/view-task/{task_id}/{project_id}',[TaskerController::class, 'view_task'])->name('share_view_task');
    Route::post('task-comment', [TaskerController::class, 'task_comment'])->name('share_task_comment');
    Route::post('download-task',[TaskerController::class, 'download_task'])->name('download_task');
    Route::post('upload-task',[TaskerController::class, 'upload_task'])->name('upload_task');

});





