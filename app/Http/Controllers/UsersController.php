<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    
    public function create(){
        return view('users.create'); 
    }

    public function store(Request $request){

        $data=$request->except(['_token']);
        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return view('login.index'); 
    }

}
