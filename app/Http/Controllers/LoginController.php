<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->isMethod('post')) {
            return view('login.index');
        } else {
            // 参数过滤
            Validator::make($request->input(), [
                'user'   => ['required', 'max:20'],
                'avatar' => 'nullable'
            ])->validate();
            
            // 用户剔重
            $data = [
                'user' => $request->input('user'),
                'avatar' => $request->input('avatar', '')
            ];
            $uid = base64_encode($data['user']);
            if (Cache::tags(['user'])->has($uid)) {
                return back()->withErrors('User '.$data['user'].' has existed.');
            }

            // 生成缓存
            Cache::tags(['user'])->forever($uid, $data);

            // 记录会话
            session('user', $data['user']);
            session('uid', $uid);
            
            return redirect('lounge');
        }
    }
}
