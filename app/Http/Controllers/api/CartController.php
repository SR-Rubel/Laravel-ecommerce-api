<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
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
            'user_id'=>'required',
            'product_id'=>'required',
        ]);

        $cart = $request->only(['user_id','product_id']);
        $response=Cart::create($cart);
        return $this->customResponse(["msg"=>'product added to cart']);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $carts=Cart::where(['user_id'=> $id])->get();

        $product = $carts->map(function($item,$index){
                return $item->product;
        });

        return $this->customResponse(["status"=>1,"data"=>$product]);

        // $product = [];
        // $i=0;
        // foreach($carts as $cart)
        // {
        //     if($cart->product){ 
        //         $product[$i] =  $cart->product;
        //         $i++;
        //     }
        // }
        // return $this->customResponse(["status"=>1,"data"=>$product]);
        
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
    // public function destroy($id)
    // {
        
    // }

    public function delete_product_from_cart($user_id,$product_id)
    {
        $product = Cart::where(['user_id'=>$user_id,'product_id'=>$product_id])->get();

        $response=0;
        if(sizeof($product))
            $response = $product[0]->delete();
            
        else return $this->errorResponse("item not found",404);
        return $this->customResponse(["msg"=>"item deleted successfully"]);
        
    }
    public function delete_cart($user_id)
    {
        $response = Cart::where('user_id',$user_id)->delete();
        if($response)
            return $this->customResponse(['msg'=>"cart deleted!"]);
        else{
            return $this->errorResponse('cart not for the user',404);
        }
    }
}

