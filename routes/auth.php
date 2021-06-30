<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\auth\{VerificationController as Email,
                                    AdminAuth,
                                    StudentAuth,
                                    TeacherAuth};
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'auth'],function (){
    //email verification routes
    Route::middleware(['Logged',"throttle:5,2"])->group(function (){
        Route::post('email/verify', [Email::class,'verify'])->name('verification.verify');
        Route::get('email/resend', [Email::class,'resend'])->name('verification.resend');
    });
    //if not verified
    Route::get('email/notice', [Email::class,'notice'])->name('verification.notice');

    //student auth routes
   Route::group([
       'prefix' => 'student'
   ],function (){
    //routes without restricted access auth
       Route::post('login'      , [StudentAuth::class,'login']       );
       Route::post('register'   , [StudentAuth::class,'register']    );
       //routes must have valid access token and user must logged in
       Route::middleware(['auth:student'])->group(function () {
           //refresh token , logout , refresh
           Route::post('logout'   , [StudentAuth::class,'logout']    );
           Route::get('refresh'    , [StudentAuth::class,'refresh'] );
           //get current authenticated user
           Route::get( 'user'    ,    [StudentAuth::class,'user']);
       });
       //student reset password routes
       //throttle
        Route::middleware("throttle:5,2")->group(function (){
           Route::post('sendPasswordResetCode', [StudentAuth::class,'sendEmail']);
           Route::post('resetPassword', [StudentAuth::class,'passwordResetProcess']);
        });
   });

    // ADMIN AUTH ROUTES
    Route::group([
        'prefix' => 'admin',
    ],function (){
        //rout without restricted access auth
        Route::post('login'      , [AdminAuth::class,'login']   )->name('admin.login');
        Route::post('register'   , [AdminAuth::class,'register']);
        //routes must have valid access token and user must logged in
        Route::middleware(['auth:admin'])->group(function () {
            //refresh token , logout , refresh
            Route::get('logout'   , [AdminAuth::class,'logout']);
            Route::get('refresh'    , [AdminAuth::class,'refresh'] );
            //get current authotocated user
            Route::get( 'user'    ,    [AdminAuth::class,'user']);
//            Route::delete('remove/{admin}', [\App\Http\Controllers\API\Admin\ViewsAJax\UsersViews::class,"deleteadmin"])->name('search.removeAdmin');
        });
        //admin reset password routes
        //throttle
        Route::middleware("throttle:5,2")->group(function (){
            Route::post('sendPasswordResetLink', [AdminAuth::class,'sendEmail']);
            Route::post('resetPassword', [AdminAuth::class,'passwordResetProcess'])->name('password.email');
        });
    });


    // Owner AUTH ROUTES
    Route::group([
        'prefix' => 'teacher',
    ],function (){
        //rout without restricted access auth
        Route::post('login'      ,      [TeacherAuth::class,'login']    );
        Route::post('register'   ,      [TeacherAuth::class,'register'] );
        //routes must have valid access token and user must logged in
        Route::middleware(['auth:teacher'])->group(function () {
            Route::post('logout'   ,    [TeacherAuth::class,'logout']   );
            Route::get( 'user'    ,    [TeacherAuth::class,'user']     );
            Route::get('refresh'    ,  [TeacherAuth::class,'refresh']  );
        });
        //Owner reset password routes
        //throttle
        Route::middleware("throttle:5,2")->group(function (){
            Route::post('sendPasswordResetLink', [TeacherAuth::class,'sendEmail']);
            Route::post('resetPassword', [TeacherAuth::class,'passwordResetProcess']);
        });
    });
});



