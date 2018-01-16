<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * 聊天室内
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function index(Request $request, $id)
    {
        $room_id = $id;
        echo 1;
    }
}
