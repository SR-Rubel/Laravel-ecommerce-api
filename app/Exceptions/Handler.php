<?php

namespace App\Exceptions;

use Throwable;


use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    // public function register()
    // {
    //     $this->reportable(function (Throwable $e) {
    //         //
    //     });
    // }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }
        if ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        }

        return parent::render($request, $e);
        
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($e instanceof ValidationException) {
            return response()->json(["erorr"=>$e->validator->errors()],422);
        }

        return $request->expectsJson()
                    ? $this->invalidJson($request, $e)
                    : $this->invalid($request, $e);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['status'=>0,'msg'=>$exception->getMessage()],401);
    }
}
