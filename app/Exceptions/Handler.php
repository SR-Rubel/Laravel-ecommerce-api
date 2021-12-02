<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class Handler extends ExceptionHandler
{
    private function successResponse($data,$code=200){
        return response()->json($data,$code);
    }

    //this will return single instance json response
    protected function oneResponse(Model $instance, $code=200)
    {
        $transformer=$instance->transformer;
        $instance=$this->transformData($instance,$transformer);

        return $this->successResponse($instance,$code);
    }

    //this will return multiple instance json response
    protected function mutliResponse(Collection $collection,$code=200)
    {
        if($collection->isEmpty()){
            return $this->successResponse(["data"=>$collection],$code);
        }

        $transformer=$collection->first()->transformer;
        $collection=$this->transformData($collection,$transformer);
        return $this->successResponse(["data"=>$collection],$code);
    }
    // this will return error response with http error code
    protected function errorResponse($msg,$code)
    {
        return response()->json(['error'=>$msg,'code'=>$code],$code);
    }

    // this will return custom response
    protected function customResponse($msg_or_data,$code=200)
    {
        return response()->json($msg_or_data,$code);
    }

    protected function transformData($data,$transformer)
    {
        $transformation=fractal($data,new $transformer);
        return $transformation->toArray();
    }


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

        else if($e instanceof ModelNotFoundException){
            $modelName=Str::lower(class_basename($e->getModel()));
            return $this->errorResponse("does not exit any {$modelName} with the specified id",404);
        }

        else if ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        }

        else if ($e instanceof AuthorizationException) {
            return $this->errorResponse($e->getMessage(),403);
        }
   
        else if ($e instanceof MethodNotAllowedException) {
            return $this->errorResponse('The specified method for the request is invalid', 405);
        }

        else if($e instanceof NotFoundHttpException){
            return $this->errorResponse('The specified URL cannot be found', 404);
        }

        else if($e instanceof HttpException){
            return $this->errorResponse($e->getMessage(), $e->getStatusCode());
        }

        else if($e instanceof QueryException){
            $errorCode = $e->errorInfo[1];

            if ($errorCode == 1451) {
                return $this->errorResponse('Cannot remove this resource permanently. It is related with any other resource', 409);
            }
        }

        else if($e instanceof TokenMismatchException){
            return redirect()->back()->withInput($request->input());
        }

        else if(config('app.debug')){

            return parent::render($request, $e);
        }

        return $this->errorResponse('Unexpected error. Try again later',500);
    }

    
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($e instanceof ValidationException) {
            return response()->json(["erorr"=>$e->validator->errors()],422);
        }
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['status'=>0,'msg'=>$exception->getMessage()],401);
    }
}
