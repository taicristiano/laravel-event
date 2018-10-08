<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class SyncFirebaseController extends Controller
{
    public function index()
    {
        //https://viblo.asia/p/dong-bo-hoa-firebase-realtime-database-trong-laravel-1Je5Ed11lnL
        User::create([
            'name' => 'T1ai nhot1112',
            'email' => '1taidepzai111112@gmail.com',
            'password' => bcrypt('123456')
        ]);
    }
}
