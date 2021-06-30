<?php


namespace App\Http\Controllers\API\Auth;


use App\Http\Traits\auth\{Auth,ChangePassword,PasswordResetRequest};
use App\Http\Traits\Responses_Trait;
use App\Http\Controllers\Controller;
class BaseAuth extends Controller
{
    use Auth , Responses_Trait ,ChangePassword ,PasswordResetRequest;
}
