<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\Dashboard\LoginController;
use App\Http\Controllers\Dashboard\Api\MigrationController;
use App\Http\Controllers\Dashboard\EmployeeController;
use App\Http\Controllers\Dashboard\GroupController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\ManagementController;
use App\Http\Controllers\Dashboard\ReportController;
use App\Http\Controllers\Dashboard\SanctionController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\ShiftController;
use App\Http\Controllers\Dashboard\TaskController;
use App\Http\Controllers\Dashboard\VacationController;
use App\Http\Controllers\Utilities\HelperControler;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

// forgatePassword
Route::get('/forgate-password', [LoginController::class, 'forgatePasswordIndex'])->name('forgatePasswordI');
Route::post('/forgate-password', [LoginController::class, 'forgatePassword'])->name('forgatePassword.store');


// change password
Route::get('/chage-password', [ChangePasswordController::class, 'index'])
    ->name('change-password')
    ->middleware('auth');
Route::post('/chage-password', [ChangePasswordController::class, 'store'])
    ->name('change-password')
    ->middleware('auth');

Route::middleware([
    'change-password',
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/shifts', [ShiftController::class, 'index'])
        ->middleware('role:admin')
        ->name('dashboard');


    // get Groups
    Route::get('/get-groups', [GroupController::class, 'getAll'])
        ->middleware('role:admin');

    Route::post('/store-new-group', [GroupController::class, 'store'])
        ->middleware('role:admin');

    Route::post('/edit-group/{group}', [GroupController::class, 'edit'])->middleware('role:admin');
    Route::get('/delete-group/{group}', [GroupController::class, 'delete'])->middleware('role:admin');
    Route::get('/get-group-days/{group}', [GroupController::class, 'getDays'])->middleware('role:admin');
    Route::post('/add-new-day/{group}', [GroupController::class, 'storeDay'])->middleware('role:admin');
    Route::delete('/delete-group-day/{shift}', [GroupController::class, 'deleteDay'])
        ->middleware('role:admin');
    Route::post('/edit-group-day', [GroupController::class, 'editDay'])->middleware('role:admin');

    //migrations
    Route::get('/migration', [MigrationController::class, 'index']);

    // get emp
    Route::get('/get-employee-withoute-fingerprint', [MigrationController::class, 'getEmp']);
    Route::get('/get-employees', [MigrationController::class, 'getAllEmps']);
    Route::post('/add-new-fingerprint', [MigrationController::class, 'storeNewFingerprint']);
    Route::get('/show-employee/{employee}', [MigrationController::class, 'show']);

    // employees
    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::post('/employee', [EmployeeController::class, 'store'])->middleware('role:admin');;
    Route::get('/get-employee/{employee}', [EmployeeController::class, 'show']);
    Route::get('/delete-employee/{employee}', [EmployeeController::class, 'destroy'])
        ->middleware('role:admin');
    Route::get('/get-career-name', [EmployeeController::class, 'getCareerNames']);
    Route::post('/add-to-group/{employee}', [EmployeeController::class, 'addToGroup']);


    // career
    Route::get('/get-career-degrees', [EmployeeController::class, 'getCareerDegree']);
    Route::get('/get-career-categories', [EmployeeController::class, 'getCareerCategory']);

    // tasks
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/add-new-task', [TaskController::class, 'store']);
    Route::get('/get-task/{task}', [TaskController::class, 'show']);

    // vacations
    Route::get('/vacations', [VacationController::class, 'index']);
    Route::post('/add-new-vaction', [VacationController::class, 'store']);
    Route::get('/get-vacation/{vacation}', [VacationController::class, 'show']);
    Route::get('/approved-vacation/{id}', [VacationController::class, 'approved']);

    //management
    Route::get('/management', [ManagementController::class, 'index']);

    // sanction
    Route::get('/get-sanction/{group?}', [SanctionController::class, 'getSanction']);
    Route::get('/close-sanction/{sanction}', [SanctionController::class, 'closeSanction']);

    // employee report
    Route::get('/report', [ReportController::class, 'index']);

    // get shifts
    Route::get('/get-shift', [VacationController::class, 'getShift']);

    // setting
    Route::get('/setting', [SettingController::class, 'index']);
    Route::post('/store-career/{type}', [SettingController::class, 'storeCareer']);
    Route::delete('/destroy_setting/{id}/{type}', [SettingController::class, 'destroySetting']);

    //set bransh session
    Route::post('/bransh-session/{id}', [HelperControler::class, 'setBranshSession']);
});


Route::any('register', function () {
    return redirect()->route('login');
})->name('register');


// get strucure child
Route::get('/get_bransh', [HelperControler::class, 'getBranshes']);
Route::get('/get_management/{bransh}', [HelperControler::class, 'getManagements']);
Route::get('/get_department/{management}', [HelperControler::class, 'getDepartments']);
Route::get('/get_unit/{department}', [HelperControler::class, 'getUnits']);
Route::post('/store_management/{id?}', [HelperControler::class, 'storeManagement']);
Route::delete('/destroy_management/{id}/{type}', [HelperControler::class, 'destroyManagement']);


Route::get('/get-vacations-for-emp/{employee}', [VacationController::class, 'getVacationsForEmps']);

Route::get('/get-tasks-for-emp/{employee}', [TaskController::class, 'getTasksForEmps']);

Route::get('/get-vacations', [VacationController::class, 'getVacations']);
Route::get('/get-tasks', [TaskController::class, 'getTasks']);
