<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Orderdetails;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'product_id' => 'required',
        ]);

        $order=$request->only(['user_id']);

        $response =Order::create($order);
        
        $details=null;
        if($response) {
            $order_details=$request->only(['product_id']);
            $order_details['order_id'] = $response->id;
            $details=Orderdetails::create($order_details);
        }

        if($details && $response) return $this->customResponse(['msg'=>'oreder created']);
        else return $this->errorResponse('order cannot be created',404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
    
        return $this->customResponse(['status'=>1,"data"=>["user_id"=>$order->user_id,"orders_details"=>$order->details] ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return $this->customResponse(["msg"=>"order deleted"]);
    }
}
