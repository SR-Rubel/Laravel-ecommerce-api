<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brand=Brand::all();
        return response()->json(['status'=>1,'data'=>$brand],200);
    }
    public function brandCategory($id)
    {
        $brand=Brand::find($id);
        if(!$brand)
        return response()->json(['status'=>0,'msg'=>'no such brand'],404);

        $categories=$brand->categories;
        return response()->json(['status'=>1,'data'=>$categories],200);
    }

    public function create(Request $request)
    {

        $request->validate([
            'name'=>'required|unique:brands',
        ]);
        
        $brand=new Brand();
        $brand->name=$request->name;
        $brand->save();
        return response()->json(['msg'=>'brand added'],200);
    }

    
    public function update(Request $request,$id)
    {
        $request->validate([
            'name'=>'required',
        ]);
        $brand=Brand::where('id',$id)->update(['name'=>$request->name]);
        return response()->json(["status"=>0,"msg"=>$brand?'brand name updated successfully':"Brand name not found",'id'=>$brand],$brand?200:404);
    }

    public function delete($id)
    {
        $brand= Brand::where('id',$id)->delete();
    return response()->json(["status"=>0,"msg"=>$brand?'brand deleted successfully':"Brand not found"],$brand?200:404);
    }
    
}

