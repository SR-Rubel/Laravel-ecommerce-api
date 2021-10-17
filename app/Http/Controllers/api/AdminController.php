<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function allUser()
    {
        $users=User::all();
        return response()->json(['status'=>1,'data'=>$users],200);
    }
    public function store()
    {
        
    }
}
