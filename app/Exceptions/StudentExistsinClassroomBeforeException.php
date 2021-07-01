<?php

namespace App\Exceptions;

use App\Http\Traits\Responses_Trait;
use Exception;

class StudentExistsinClassroomBeforeException extends Exception
{
    use Responses_Trait;
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return $this->returnErrorMessage($this->getMessage(), 422);
    }
}
