<?php


namespace App\Http\Traits\auth;



use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Mixed_;
use Symfony\Component\HttpFoundation\Response;

trait Auth
{

    /**
     * log the user to be authenticated by one if his identifies.
     *
     * @param $model
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function Login_By_identifier($model, $request)
    {
            declare_:{
                $user=false;
                $credentials=$request->only(['email','password']);            //set $credentials
            }
            //authenticate $credentials
            $token = $this->authenticate_user($user, $credentials, $request);//authenticate
            if (!$token) // if user exists
                //if any error ///////////// return general error rather than ($user->original)
               return response(["general"=>"Invalid Email Or Password ."], Response::HTTP_UNPROCESSABLE_ENTITY);
        //if authenticated
        return $this->respondWithToken($token, $this->get_data(['expire','role'], [$request->remember_me ? 20160 : 1440,$model->getJWTCustomClaims()['role']]), 'successfully logged in');
    }


    /**
     * log the user to be authenticated by one if his identifies.
     *
     * @param $user
     * @param $credentials
     * @param $request
     */
    public function authenticate_user($user, $credentials, $request)
    {
        return $token = $this->guard()->setTTL($request->remember_me ? 20160 : 1440)->claims([
            "user" =>  $user->name??'',
            "username" => $user->username ??''
        ])->attempt($credentials);
    }

    /**
     * helper array to get user data.
     *
     * @param null $kies
     * @param null $values
     * @return array
     */
    public function get_data($kies = null, $values = null)
    {
        return [
            "user" => \Auth::user(),
            "additional_data" => !isset($kies) || !isset($values) ? null : array_combine($kies, $values)
        ];
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        return $this->returnData($this->get_data(['identifier'], ['token']));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout(true);

        return response()->json([
            'status' => true,
            'message' => 'Successfully logged out'
        ], 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh_Token($model)
    {
        $token = $this->guard()->claims([
            $model->getJWTCustomClaims(),
            "user" => auth()->user()->name,
            "username" => auth()->user()->username
        ])->refresh();
        return
            $this->respondWithToken(
                $token
                ,
                $this->get_data(['identifier'], ['token'])
            );
    }

}
