<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function allUser()
    {
        $users=User::all();
        return response()->json(['status'=>1,'data'=>$users],200);
    }
}
