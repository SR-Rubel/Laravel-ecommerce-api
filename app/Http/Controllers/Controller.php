<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Laravel single vendor ecommerce api",
     *      description="making a personal shop",
     *      @OA\Contact(
     *          email="rubel162765@gmail.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     * 
     * @OA\SecurityScheme(
     *    securityScheme="bearerAuth",
     *    in="header",
     *    name="bearerAuth",
     *    type="http",
     *    scheme="bearer",
     *    bearerFormat="passport",
     * ),
     *
     * @OA\Server(
     *      url="http://mayabotishop.herokuapp.com/api/",
     *      description="Demo API Server"
     * )

     *
     *
     */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
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
}
