<?php

use Illuminate\Support\Facades\{Route, Auth, Session};
use App\Http\Controllers\Admin\{DashboardController, UserController, CategoryController, ProductController};
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
    Route::group(['middleware' => ['auth'], 'as' => '.'], function() {
        Route::get('dashboard', DashboardController::class)->name('dashboard'); # invokable

        Route::resource('user', UserController::class);
        Route::match(['GET','POST'], 'user_trash/{user?}', [UserController::class, 'trash'])->name('user.trash')->withTrashed();

        Route::resource('category', CategoryController::class);
        Route::match(['GET','POST'], 'category_trash/{category?}', [CategoryController::class, 'trash'])->name('category.trash')->withTrashed();

        Route::resource('product', ProductController::class);
        Route::match(['GET','POST'], 'product_trash/{product?}', [ProductController::class, 'trash'])->name('product.trash')->withTrashed();
        Route::post('add-product-image/{product}', [ProductController::class, 'addProductImage']);

        Route::post('logout', function(){
            Session::flush();
            Auth::logout();
            return to_route('admin.login');
        })->name('logout');
    });
    Route::middleware('guest')->group(function(){
        Route::controller(RegisterController::class)->group(function(){
            Route::match(['GET','POST'], 'register', 'register')->name('.register');
            Route::get('registration_email_confirmation/{token}', 'verifyEmail')->name('.registration_email_confirmation')->middleware('signed');
        });
        Route::match(['GET','POST'], 'login', LoginController::class)->name('.login');
        Route::controller(ForgotPasswordController::class)->group(function(){
            Route::match(['GET','POST'], 'forgot-password', 'forgotPassword')->name('.forgot-password');
            Route::get('password-reset/{token}', 'tokenVerify')->name('.token-verify')/*->middleware('signed') # check routeMiddleware*/;
            Route::post('new-password', 'newPassword')->name('.new-password');
        });
    });
});
