<?php
defined("MYSQL_CONFIG") ?: define('MYSQL_CONFIG', [
    'host'              => '127.0.0.1',
    'port'              => 3306,
    'user'              => 'demo',
    'password'          => '123456',
    'database'          => 'demo',
    'timeout'           => 5,
    'charset'           => 'utf8mb4',
    'useMysqli'         => true,
    'intervalCheckTime' => 15 * 1000, // 设置 连接池定时器执行频率
    'maxIdleTime'       => 10, // 设置 连接池对象最大闲置时间 (秒)
    'maxObjectNum'      => 400, // 设置 连接池最大数量
    'minObjectNum'      => 100, // 设置 连接池最小数量
    'getObjectTimeout'  => 3.0, // 设置 获取连接池的超时时间
    'loadAverageTime'   => 0.001, // 设置 负载阈值
]);
