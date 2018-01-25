<?php

use \Workerman\Worker;
use \GatewayWorker\BusinessWorker;
use \Workerman\Autoloader;

/**
 * BusinessWorker进程负责运行业务逻辑, 实际的业务处理由eventHandler指定的类来处理，默认是Events.php
 */

require_once __DIR__ . '/../../vendor/autoload.php';

$worker = new BusinessWorker();
$worker->name = 'ChatBusinessWorker';
$worker->count = 4;
$worker->registerAddress = '127.0.0.1:1238'; // 用于和Gateway进程通信，与Gateway进程的注册地址保持一致

if (!defined('GLOBAL_START')) {
    Worker::runAll();
}