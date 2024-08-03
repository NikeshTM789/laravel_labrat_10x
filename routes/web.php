<?php

use Illuminate\Support\Facades\{Route, Auth, Session};
use App\Http\Controllers\Admin\{DashboardController, UserController, CategoryController, ProductController, RoleController};
use App\Http\Controllers\Auth\{LoginController, RegisterController, ForgotPasswordController};
use App\Models\{Product, User};
use Illuminate\Http\Request;
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

Route::get('get-response', function(){
    $user = App\Models\User::find(111);
    $result = \App\Models\Product::with('seller:id,name')->whereBelongsTo($user,'seller')->get();
    dd($result);
})->name('get_response');

Route::group(['prefix' => 'admin', 'as' => 'admin'], function() {
    Route::group(['middleware' => ['auth'], 'as' => '.'], function() {
        Route::get('/', DashboardController::class)->name('dashboard'); # invokable

        Route::resource('user', UserController::class);
        Route::match(['GET','POST'], 'user_import', [UserController::class, 'import'])->name('user.import');
        Route::match(['GET','POST'], 'user_trash/{user?}', [UserController::class, 'trash'])->name('user.trash')->withTrashed();

        Route::resource('role', RoleController::class)->except(['show'])->missing(function(Request $request){
            return response(['message' => 'Role Could not be found'], 404);
        });

        Route::match(['GET','POST'], 'role_trash/{role?}', [RoleController::class, 'trash'])->name('role.trash')->withTrashed();

        Route::resource('category', CategoryController::class);
        Route::match(['GET','POST'], 'category_trash/{category?}', [CategoryController::class, 'trash'])->name('category.trash')->withTrashed();

        Route::resource('product', ProductController::class);
        Route::match(['GET','POST','DELETE'],'product_media/{product:uuid}/{type?}', [ProductController::class, 'media'])->name('product.media')->whereIn('type',['featured','gallery']);

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
