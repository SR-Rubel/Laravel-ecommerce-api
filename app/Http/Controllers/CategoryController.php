<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories=Category::all();
        return response()->json(['status'=>1,'data'=>$categories],200);
    }

    public function create(Request $request)
    {

        $request->validate([
            'name'=>'required',
        ]);

        $category=new Category();
        $category->name=$request->name;
        $category->save();
        $last=DB::table('categories')->latest()->first();

        return response()->json(["status"=>1,"msg"=>'categroy added','data'=>$last],200);
    }

    public function delete($id)
    {
        $cat=Category::where('id',$id)->delete();
        return response()->json(["status"=>0,"msg"=>$cat?'categroy deleted successfully':"category not found",'id'=>$id],$cat?200:404);
    }

    public function update(Request $request,$id)
    {
         $request->validate([
             'name'=>'required',
        ]);
        $cat=Category::where('id',$id)->update(['name'=>$request->name]);
        return response()->json(["status"=>1,"msg"=>$cat?'categroy updated successfully':"category not found",'id'=>$cat],$cat?200:404);
    }

}
