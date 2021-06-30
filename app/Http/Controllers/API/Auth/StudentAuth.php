<?php

namespace App\Http\Controllers\API\auth;

use App\Exceptions\UserNotRegistered;
use App\Models\Student;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\{ DB, Hash ,Auth};
use App\Http\Requests\auth\{LoginRequest, RegisterRequest};
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\API\auth\BaseAuth as Controller;

class StudentAuth extends Controller
{
    private const guard = 'student';

    public function __construct()
    {
        Auth::shouldUse(self::guard);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request) {//by username
        $data = $request->only(['name','email','password','phone']);
        Student::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]) ?? throw new UserNotRegistered('Student Not Registered');

        return $this->returnSuccessMessage("the student registered successfully ." , Response::HTTP_CREATED);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        return $this->Login_By_identifier(new Student(),$request);
    }


    protected function guard(){
        return Auth::guard(self::guard);
    }


    // Reset password
    public function resetPassword($request) {
        // find email
        $code = DB::table('password_resets')->where([
            'code' => $request->code
        ])->get();
        $userData = Teacher::whereEmail($code[0]->email)->first();
        // update password
        $userData->update([
            'password'=>bcrypt($request->password),
            'password_rested_at'=>Carbon::now()
        ]);
        // remove verification data from db
        $this->updatePasswordRow($request)->delete();

        // reset password response
        return response()->json([
            'data'=>'Password has been updated successfully.'
        ], Response::HTTP_CREATED);
    }

    //this is a function to get your email from database
    public function validateEmail($email)
    {
        return Teacher::where('email', $email)->first();
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->refresh_Token(new Teacher());
    }
}
