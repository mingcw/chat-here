<?php
use \GatewayWorker\Lib\Gateway;

class Events
{
    // 当有客户端连接时，将client_id返回，让mvc框架判断当前uid并执行绑定
    public static function onConnect($client_id)
    {
        Gateway::sendToClient($client_id, json_encode(array(
            'type'      => 'init',
            'client_id' => $client_id
        )));
    }

    /**
     * 有消息时触发该方法。GatewayWorker建议不做任何业务逻辑，onMessage留空即可
     * @param  [type] $client_id 发消息的$client_id
     * @param  [type] $message   消息
     * @return [type]            [description]
     */
    public static function onMessage($client_id, $message)
    {

    }

    /**
     * 当用户断开连接时触发的方法
     * @param integer $client_id 断开连接的客户端client_id
     * @return void
     */
    public static function onClose($client_id)
    {
        // 房间广播有连接关闭的信号
        $room_id = $_SESSION['room_id'];
        $uname   = $_SESSION['uname'];

        if (Gateway::getClientCountByGroup($room_id)) {
            Gateway::sendToGroup($room_id, json_encode(array(
                'type'      => 'close',
                'uname'     => $uname
            )));
        }   
    }
}