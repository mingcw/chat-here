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
     * 聊天室内
     * @param  Request $request [description]
     * @param  id      $id      [description]
     * @return [type]           [description]
     */
    public function index(Request $request, $id)
    {
        $room   = Room::find($id);
        if (!$room) {
            return redirect('lounge');
        }
        $uname  = session('uname');
        $avatar = session('avatar');

        session(['room_id' => $id]);

        return view('room.index', [
            'room'   => $room,
            'uname'  => $uname,
            'avatar' => $avatar
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
        $bubble    = $request->input('bubble');

        $uid       = session('uid');
        $uname     = session('uname');
        $avatar    = session('avatar');
        $room_id   = session('room_id');

        // 绑定uid和client_id、加入房间
        Gateway::bindUid($client_id, $uid);
        Gateway::joinGroup($client_id, $room_id);

        // 记录会话
        session(['client_id' => $client_id]);
        session(['bubble' => $bubble]);
        Gateway::setSession($client_id, [
            'uid'     => $uid,
            'uname'   => $uname,
            'avatar'  => $avatar,
            'bubble'  => $bubble,
            'room_id' => $room_id
        ]);

        // 房间内广播：萌新进来了
        Gateway::sendToGroup($room_id, json_encode([
            'type'      => 'comein',
            'uname'     => $uname
        ]));

        // 给萌新发送房间客户列表
        $sessions = Gateway::getClientSessionsByGroup($room_id);
        $users_list = [];
        foreach ($sessions as $client_id => $item) {
            $users_list[$item['uid']] = $item['uname'];
        }
        $new_message = ['type' => 'comein'];
        $new_message['users_list'] = $users_list;
        Gateway::sendToUid($uid, json_encode($new_message));
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
}
