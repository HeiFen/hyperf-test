<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
$formatter = [
    'class' => Monolog\Formatter\LineFormatter::class,
    'constructor' => [
        'format' => null,
        'dateFormat' => 'Y-m-d H:i:s',
        'allowInlineLineBreaks' => true,
    ],
];

return [
    'default' => [
        'handler' => [
            'class' => Monolog\Handler\RotatingFileHandler::class,
            'constructor' => [
                'filename' => BASE_PATH . '/runtime/logs/debug/hyperf.log',
                'level' => Monolog\Level::Debug
            ],
        ],
        'formatter' => $formatter,
    ],
    'error' => [
        'handler' => [
            'class' => Monolog\Handler\RotatingFileHandler::class,
            'constructor' => [
                'filename' => BASE_PATH . '/runtime/logs/error/hyperf.log',
                'level' => Monolog\Level::Error
            ],
        ],
        'formatter' => $formatter,
    ]
];
