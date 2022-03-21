<?php

namespace App\Http\Controllers;
use Response;
use App\Models\User;
use App\Models\message;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    { 
          return Response::json(User::all());
    }
    public function make_user_online(Request $request)
    {
        message::where('id',auth()->id())->update(['status' => "online"]);
    }
    public function update_real_time(Request $request)
    {
       return view('/');
        
    }
    
     
}
