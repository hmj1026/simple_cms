<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $ret = [];

        $ret['redirectTime'] = $redirectTime = 3000;
        
        $ret['redirectPath']  = $redirectPath = Auth::user()->type === User::TYPE_NORMAL
            ? route('post.index')
            : route('log.index');
        $ret['redirectMsg'] = \sprintf('即將在 %d 秒後，跳轉到 %s', $redirectTime/1000, $redirectPath);
        
        return view('home', compact('ret'));
    }

}