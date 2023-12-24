<?php

use Illuminate\Support\Facades\{Route, Auth, Session};
use App\Http\Controllers\Admin\{DashboardController};
use App\Http\Controllers\Auth\{LoginController, RegisterController, ForgotPasswordController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin', 'as' => 'admin'], function() {
    Route::group(['middleware' => ['auth']], function() {
        Route::get('/', DashboardController::class); # invokable
        Route::post('logout', function(){
            Session::flush();
            Auth::logout();
            return to_route('admin.login');
        })->name('.logout');
    });
    Route::middleware('guest')->group(function(){
        Route::match(['GET','POST'], 'register', RegisterController::class)->name('.register');
        Route::match(['GET','POST'], 'login', LoginController::class)->name('.login');
        Route::controller(ForgotPasswordController::class)->group(function(){
            Route::match(['GET','POST'], 'forgot-password', 'forgotPassword')->name('.forgot-password');
            Route::get('password-reset/{token}', 'tokenVerify')->name('.token-verify')/*->middleware('signed') # check routeMiddleware*/;
            Route::post('new-password', 'newPassword')->name('.new-password');
        });
    });
});
