<?php

namespace App\Http\Controllers\api;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    public function index()
    {
        $sub_categories=SubCategory::all();
        return response()->json(['status'=>1,'data'=>$sub_categories],200);
    }
    public function cat_wise_subcat($id)
    {
        $sub_categories=Category::find($id)->sub_categories;
        return response()->json(['status'=>1,'data'=>$sub_categories],200);
    }

    public function create(Request $request)
    {

        $request->validate([
            'name'=>'required',
            'category_id'=>'required'
        ]);
        $cat=Category::find($request->category_id);

        if(!$cat){
            return response()->json(['msg'=>'category not found'],404);
        }
        $subcategory=new SubCategory();
        $subcategory->category_id=$request->category_id;
        $subcategory->name=$request->name;
        $subcategory->save();
        $last=DB::table('sub_categories')->latest()->first();
        return response()->json(['status'=>1,'data'=>$last,'msg'=>'sub category added'],200);

        // return response()->json(["status"=>1,"msg"=>'sub categroy added'],200);
    }

    public function delete($id)
    {
        $cat= SubCategory::where('id',$id)->delete();
        return response()->json(["status"=>1,"msg"=>$cat?'sub categroy deleted successfully':"sub category not found"],$cat?200:404);
    }

    public function update(Request $request,$id)
    {
         $request->validate([
             'name'=>'required',
        ]);
        $cat=SubCategory::where('id',$id)->update(['name'=>$request->name]);
        return response()->json(["status"=>0,"msg"=>$cat?'sub categroy updated successfully':"sub category not found",'id'=>$cat],$cat?200:404);
    }
}
