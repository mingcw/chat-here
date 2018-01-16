<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Room;

/**
 * 休息室
 */
class LoungeController extends Controller
{
    /**
     * 大厅
     * @return [type]           [description]
     */
    public function index()
    {
        return view('lounge.index');
    }

    /**
     * 创建房间
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function create(Request $request)
    {
        if (!$request->isMethod('post')) {
            return view('lounge.create');
        } else {
            $input = [
                'name'        => $request->input('name'),
                'description' => $request->input('description') ?: '',
                'capacity'    => $request->input('capacity')
            ];

            // 过滤
            Validator::make($input, [
                'name'        => ['required', 'max:20'],
                'description' => 'max:140',
                'capacity'    => 'required|numeric'
            ])->validate();

            // 剔重
            if (Room::where('name', $input['name'])->count()) {
                return back()->withErrors('Room '.$input['name'].' has existed.');
            }

            // 入库
            Room::create([
                'name'        => $input['name'],
                'description' => $input['description'],
                'capacity'    => $input['capacity'],
                'username'    => session('uname'),
            ]);

            return redirect('lounge');
        }
    }
}
