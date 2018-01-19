<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\User;

class LoginController extends Controller
{
    /**
     * 登录
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function index(Request $request)
    {
        if (!$request->isMethod('post')) {
            return view('login.index');
        } else {
            $input = [
                'username' => $request->input('username'),
                'password' => $request->input('password'),
                'avatar'   => $request->input('avatar') ?: 'avatar'.mt_rand(1, 18)
            ];

            // 过滤
            Validator::make($input, [
                'username'   => ['required', 'max:20'],
                'password'   => ['required', 'max:40'],
            ])->validate();

            // 校验
            $user = User::where('username', $input['username'])->first();
            if (!$user) {
                return back()->withErrors($input['username']." doesn't exist.");
            } else if (md5($input['password']) != $user->password) {
                return back()->withErrors("Password is invalid.");
            }

            // 记录
            session(['uid'    => $user->token]);
            session(['uname'  => $input['username']]);
            session(['avatar' => $input['avatar']]);
            
            return redirect('lounge');
        }
    }

    /**
     * 注册
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function register(Request $request)
    {
        if (!$request->isMethod('post')) {
            return view('login.register');
        } else {
            $input = [
                'username' => $request->input('username'),
                'password' => $request->input('password'),
            ];

            // 过滤
            Validator::make($input, [
                'username'   => ['required', 'max:20'],
                'password'   => ['required', 'max:40'],
            ])->validate();
            
            // 剔重
            if (User::where('username', $input['username'])->count()) {
                return back()->withErrors('User '.$input['username'].' has existed.');
            }

            // 入库
            User::create([
                'username' => $input['username'],
                'password' => md5( $input['password'] ),
                'token'    => md5( $input['username'].time().mt_rand(1000, 9999) ),
                'lastloginip' => $request->ip(),
                'lastlogintime' => time()
            ]);

            return redirect()->route('login');
        }
    }
}
