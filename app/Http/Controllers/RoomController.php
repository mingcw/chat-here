<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room; 
use GatewayClient\Gateway;

class RoomController extends Controller
{
    public function __construct()
    {
        Gateway::$registerAddress = '127.0.0.1:1238';
    }

    /**
     * 进入房间
     * @param  Request $request [description]
     * @param  id      $id      [description]
     * @return [type]           [description]
     */
    public function index(Request $request, $id)
    {
        $room   = Room::find($id);
        if (!$room) {
            return redirect('lounge');          // 房间不存在，重定向到休息室
        }
        if ($room->number >= $room->capacity) {
            return redirect('lounge');          // 房间满客了，重定向到休息室
        }
        $room_id = session('room_id');
        if ($room_id && $room_id != $id) {
            return redirect('room/'. $room_id); // 重定向到之前从网页关闭的房间里
        }

        $uname  = session('uname');
        $avatar = session('avatar');

        $bubble = ['gray', 'purple', 'blue', 'green', 'yellow', 'red'][mt_rand(0, 5)];
        session(['bubble' => $bubble]);         // 分配一个聊天气泡，记录下来
        session(['room_id' => $id]);            // 记录所在房间号

        return view('room.index', [
            'room'    => $room,
            'uname'   => $uname,
            'avatar'  => $avatar,
            'bubble'  => $bubble,
            'room_id' => $id
        ]);
    }

    /**
     * 绑定Gateway连接的client_id与当前uid
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function bind(Request $request)
    {
        $client_id = $request->input('client_id');
        $uid       = session('uid');
        $uname     = session('uname');
        $avatar    = session('avatar');
        $bubble    = session('bubble');
        $room_id   = session('room_id');

        // 绑定uid和client_id、加入房间
        Gateway::bindUid($client_id, $uid);
        Gateway::joinGroup($client_id, $room_id);

        // 记录会话
        session(['client_id' => $client_id]); // Laravel 负责
        Gateway::setSession($client_id, [     // GatewayWorker 负责
            'uid'     => $uid,
            'uname'   => $uname,
            'avatar'  => $avatar,
            'bubble'  => $bubble,
            'room_id' => $room_id
        ]);

        // 房间内广播：萌新进入，发送最新的用户列表
        $sessions = Gateway::getClientSessionsByGroup($room_id);
        $users_list = [];
        foreach ($sessions as $client_id => $item) {
            $users_list[$item['uid']] = $item['uname'];
        }
        Gateway::sendToGroup($room_id, json_encode([
            'type'       => 'comein',
            'uname'      => $uname,
            'users_list' => $users_list
        ]));

        // 更新房间人数
        Room::where('id', $room_id)->update(['number' => count($users_list)]);
    }

    /**
     * 发言
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function say(Request $request)
    {
        $type      = $request->input('type') ?: '';
        $content   = htmlspecialchars($request->input('content'));
        $uid       = session('uid');
        $uname     = session('uname');
        $avatar    = session('avatar');
        $bubble    = session('bubble');
        $room_id   = session('room_id');

        switch ($type) {
            case 'all': // 公聊
                Gateway::sendToGroup($room_id, json_encode([
                    'type'      => 'all',
                    'uid' => $uid,
                    'uname'     => $uname,
                    'avatar'    => $avatar,
                    'bubble'    => $bubble,
                    'content'   => preg_replace('/^\s*@me/i', '', $content)
                ]));
                break;
            case 'to':  // 私聊
                $to_uid = $request->input('to_uid');
                Gateway::sendToUid($to_uid, json_encode([
                    'type'      => 'to',
                    'uid'       => $uid,
                    'uname'     => $uname,
                    'avatar'    => $avatar,
                    'bubble'    => $bubble,
                    'content'   => '<a href="javascript:;" style="color: inherit;">@me</a> '.$content
                ]));
                $to_uname = $request->input('to_uname');
                Gateway::sendToUid($uid, json_encode([
                    'type'      => 'to',
                    'uid'       => $uid,
                    'uname'     => $uname,
                    'avatar'    => $avatar,
                    'bubble'    => $bubble,
                    'content'   => '<a href="javascript:;" style="color: inherit;">@'.$to_uname.'</a> '.$content
                ]));
                break;
            default:
                break;
        }
    }

    /**
     * 刷新房间用户列表
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function flush(Request $request)
    {
        $room_id = $request->input('room_id');
        $sessions = Gateway::getClientSessionsByGroup($room_id);
        $users_list = [];
        foreach ($sessions as $client_id => $item) {
            $users_list[$item['uid']] = $item['uname'];
        }
        $new_message = ['type' => 'flush'];
        $new_message['users_list'] = $users_list;
        Gateway::sendToGroup($room_id, json_encode($new_message));

        // 更新房间人数
        Room::where('id', $room_id)->update(['number' => count($users_list)]);
    }

    /**
     * 离开房间
     * @return [type] [description]
     */
    public function leave()
    {
        $room_id = session('room_id');

        $room = Room::find($room_id);
        if($room->number > 1){
            Room::where('id', $room_id)->update(['number' => $room->number - 1]);
        } else {
            Room::where('id', $room_id)->update(['number' => 00000000000000000]); // 整齐多了-_-||
        }
        session(['room_id' => null]);

        return redirect('lounge'); // 重定向到休息室
    }

    /**
     * 播放音乐
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function music(Request $request)
    {
        $music_type = $request->input('music_type');
        $room_id = session('room_id');

        if ($music_type == 'cloud') {      // 基于 skPlayer 播放器的两种格式之一：网易云音乐歌单
            $playlist_id = $request->input('playlist_id');
            Gateway::sendToGroup($room_id, json_encode([
                'type' => 'music',
                'music_type' => $music_type,
                'playlist_id' => $playlist_id
            ]));
        } else if ($music_type == 'file') { // 基于 skPlayer 播放器的两种格式之一：自定义url文件
            $name = $request->input('name');
            $src = $request->input('src');
            Gateway::sendToGroup($room_id, json_encode([
                'type' => 'music',
                'music_type' => $music_type,
                'name' => $name,
                'src'  => $src
            ]));
        }        
    }
}
