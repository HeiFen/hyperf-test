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
namespace App\Exception\Handler;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

use function Hyperf\Config\config;
use function Hyperf\Support\env;

class AppExceptionHandler extends ExceptionHandler
{
    public function __construct(protected StdoutLoggerInterface $logger)
    {
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->logger->error(sprintf('%s[%s] in %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()));
        $this->logger->error($throwable->getTraceAsString());
        
        // 格式化输出
        $data = json_encode([
            'code' => $throwable->getCode(),
            'message' => env('APP_ENV') == 'production'? "service error" : $throwable->getMessage(),
            'data' => null
        ], JSON_UNESCAPED_UNICODE);
        return $response->withAddedHeader('Content-Type', 'application/json')->withStatus(500)->withBody(new SwooleStream($data));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
