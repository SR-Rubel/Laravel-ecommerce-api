<?php

namespace App\Http\Controllers\api;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    

    public function index()
    {
        $products=Product::simplepaginate(15);

        return response()->json(['status'=>1,'data'=>$products],200);
    }

    public function create(Request $request)
    {

        $request->validate([
            'category_id'=>'required',
            'name'=>'required',
            'details'=>'required',
            'price'=>'required',
            'image'=>'required',
        ]);
        
        $product=new Product();
        
        $product->name=$request->name;
        $product->category_id=$request->category_id;
        $product->sub_category_id=$request->subcategory_id;
        $product->brand_id=$request->brand_id;

        if($product->category_id&&$product->brand_id)
        {
            $brand=Brand::find($product->brand_id);
            $cat=Category::find($product->category_id);
            if($brand && $cat){
                if(!$brand->categories()->where('category_id',$product->category_id)->exists())
                    $brand->categories()->attach($product->category_id);
            }
            else
            return response()->json(['status'=>0,'msg'=>'brand or category not found'],404);
        }

        $product->details=$request->details;
        $product->price=$request->price;
        $product->size=$request->size;
        $product->color=$request->color;
        $product->discount_price=$request->discount_price;
        $product->stockout=$request->stockout;
        $product->hot_deal=$request->hot_deal;
        $product->buy_one_get_one=$request->buy_one_get_one;
        $image=$request->image;
        $product->image=$image;
        if($image){
            $image_f=uniqid().'.'.'jpg';
            // $path = public_path()$image_f;
            Image::make($image)->resize(500,300)->save(public_path('images/products/'.$image_f).'',100,'jpg');
            $product->image=$image_f;
        }

        $product->save();
        $last=DB::table('products')->latest()->first();
        return response()->json(['status'=>1,'data'=>$last,'msg'=>'product added'],200);
    }


    public function show($id)
    {
        $product=Product::findOrFail($id);
        $product->category;
        $product->subcategory;
        $product->brand;
        return $this->customResponse($product);
    }
    
    public function update(Request $request,$id)
    {
        $request->validate([
            'category_id'=>'required',
            'name'=>'required',
            'details'=>'required',
            'price'=>'required',
            'image'=>'required',
        ]);

        $up_product['name']=$request->name;
        $up_product['details']=$request->details;
        $up_product['price']=$request->price;
        $up_product['size']=$request->size;
        $up_product['color']=$request->color;
        $up_product['discount_price']=$request->discount_price;
        $up_product['stockout']=$request->stockout;
        $up_product['hot_deal']=$request->hot_deal;
        $up_product['buy_one_get_one']=$request->buy_one_get_one;
        $image=$request->image;
        $up_product['image']=$image;

        if($image){
            // deleting previous image from local directory
            $prev_product=Product::find($id);
            unlink(public_path('images/products/').$prev_product->image);

            //saving updated image in local directory and in database
            $image_f=uniqid().'.'.'jpg';
            // Image::make($image)->resize(500,300)->save(public_path('images/products/'.$image_f).'',5,'jpg');
            // image can be resize also image encoding can change by Image pakage
            // here 5 is for image quality or compression in can be from 0 to 100
            Image::make($image)->save(public_path('images/products/'.$image_f).'',100,'png');
            $up_product['image']=$image_f;
        }

        $up_product=Product::where('id',$id)->update($up_product);
        return response()->json(["status"=>0,"msg"=>$up_product?'product updated successfully':"product name not found",'id'=>$up_product],$up_product?200:404);
    }

    public function delete($id)
    {
        $deleted_product=Product::find($id);
        $product= Product::where('id',$id)->delete();

        // delete image from public directory
        if($product)

            if(file_exists(public_path('images/products/').$deleted_product->image))
                unlink(public_path('images/products/').$deleted_product->image);

        //deleting empty categories of brand where no product is available
        if($product){

           if(Brand::find($deleted_product->brand_id) )
            if(Brand::find($deleted_product->brand_id)->categories()->where('category_id',$deleted_product->category_id)->exists()){
                    if(!Category::find($deleted_product->category_id)->products()->where('brand_id',$deleted_product->brand_id)->exists())
                        Brand::find($deleted_product->brand_id)->categories()->detach($deleted_product->category_id);
        
                }
        }


    return response()->json(["status"=>0,"msg"=>$product?'product deleted successfully':"product not found"],$product?200:404);
    }


    public function cat_wise_products($id)
    {
        $products=Category::findOrFail($id)->products()->get();
        return $this->customResponse($products);
    }

    public function subCat_wise_products($id)
    {
        $products=SubCategory::findOrFail($id)->products()->get();
        return $this->customResponse($products);
    }
    public function brand_wise_products($id)
    {
        $products=Brand::findOrFail($id)->products()->get();
        return $this->customResponse($products);
    }


}
