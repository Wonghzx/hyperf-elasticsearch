<?php

declare(strict_types=1);


return [
    # 客户端配置
    'client' => [
        'hosts' => [
            env('ELASTICSEARCH_HOST', 'http://192.168.1.111:9200'),
        ],
        'retries' => 1,
    ],

    # 连接池设置
    'pool' => [
        'enabled' => true,
        'min_connections' => 1,
        'max_connections' => 30,
        'wait_timeout' => 3.0,
        'max_idle_time' => 60.0,
    ],

    # Elasticsearch 日志设置
    'logger' => [
        'enabled' => false,
        'name' => 'elasticsearch',
        'group' => 'default',
    ],
];