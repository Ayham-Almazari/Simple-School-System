<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\Admin;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\{ DB, Hash ,Auth};
use App\Http\Requests\auth\{LoginRequest, RegisterRequest};
use App\Http\Controllers\API\auth\BaseAuth as Controller;
use Symfony\Component\HttpFoundation\Response;
class AdminAuth extends Controller
{
    private const admin = 'admin';
    public function __construct()
    {
        Auth::shouldUse(self::admin);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request) {//by username
        $data = $request->only(['name','email','password']);
        return $this->returnSuccessMessage('sddssd');
        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }


    /**
     * Get a JWT via given credentials.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
       return $this->Login_By_identifier(new Admin(),$request);
    }


    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->refresh_Token(new Admin());
    }

    public function guard(){
        return Auth::guard(self::admin);
    }


    // Reset password
    public function resetPassword($request) {
        // find email
        $code = DB::table('password_resets')->where([
            'code' => $request->code
        ])->get();
        $userData = Admin::whereEmail($code[0]->email)->first();
        // update password
        $userData->update([
            'password'=>bcrypt($request->password),
            'password_rested_at'=>Carbon::now()
        ]);
        // remove verification data from db
        $this->updatePasswordRow($request)->delete();

        // reset password response
        return $this->returnSuccessMessage('Password has been updated successfully.',Response::HTTP_CREATED);

    }


    //this is a function to get your email from database
    public function validateEmail($email)
    {
        return Admin::where('email', $email)->first();
    }



}

