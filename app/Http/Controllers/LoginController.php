<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\User;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->isMethod('post')) {
            return view('login.index');
        } else {
            $input = [
                'username' => $request->input('username'),
                'avatar'   => $request->input('avatar') ?: ''
            ];

            // 过滤
            Validator::make($input, [
                'username'   => ['required', 'max:20'],
                'avatar' => 'nullable'
            ])->validate();
            
            // 剔重
            if (User::where('username', $input['username'])->count()) {
                return back()->withErrors('User '.$input['username'].' has existed.');
            }

            // 入库
            $uid = User::insertGetId([
                'username'      => $input['username'],
                'avatar'        => $input['avatar'],
                'lastloginip'   => $request->ip(),
                'lastlogintime' => time(),
                'lastchattime'  => time()
            ]);

            // 记录
            session(['uid'    => $uid]);
            session(['uname'  => $input['username']]);
            session(['avatar' => $input['avatar']]);
            
            return redirect('lounge');
        }
    }
}
