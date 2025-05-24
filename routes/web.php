<?php

use App\Http\Controllers\Application\Settings\Master\Roles\RoleController;
use App\Http\Controllers\Application\Users\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Auth::routes();
//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::get('get-global-helper', [HomeController::class, 'fetchGlobalHelperClass'])->name('get-global-helper');

/*
|--------------------------------------------------------------------------
| Quiz Admin Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
    Route::group(['prefix' => 'settings'], function () {
        Route::group(['prefix' => 'master'], function () {
            Route::resource('roles', RoleController::class);
            Route::get('get-roles', [RoleController::class, 'getData'])->name('get-roles');

            Route::resource('users', UserController::class);
            Route::get('get-users', [UserController::class, 'getData'])->name('get-users');
            Route::post('users/change-status', [UserController::class, 'changeStatus'])->name('users.change-status');
        });
    });

});

/*
|--------------------------------------------------------------------------
| Quiz Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/migrtae', function () {
    \Artisan::call('migrate');
    dd('Migrated');
});

Route::get('/optimize', function () {
    \Artisan::call('optimize');
    dd('optimized');
});

Route::get('/testt', function () {
    \Artisan::call('test:run');
    dd('reset');
});

Route::get('/evv', function () {
    \Artisan::call('course:evaluate');
    dd('reset');
});

Route::get('/storage', function () {
    \Artisan::call('storage:link');
    dd('storage');
});

// Clear route cache command
Route::get('/clear-route-cache', function () {
    \Artisan::call('route:clear');
    return "Route cache cleared successfully!";
});
