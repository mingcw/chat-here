<?php

use \Workerman\Worker;
use \GatewayWorker\Register;

/**
 * Register 服务。用于协调Gateway进程和BusinessWorker进程进行内部通讯
 */

require_once __DIR__ . '/../../vendor/autoload.php';

$register = new Register('text://0.0.0.0:1238'); // 必须text协议

if (!defined('GLOBAL_START')) {
    Worker::runAll();
}