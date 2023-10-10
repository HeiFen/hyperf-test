<?php

declare(strict_types=1);

namespace App\Middleware;

use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ResponseMiddleware implements MiddlewareInterface
{
    public function __construct(protected ContainerInterface $container)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $reponse = $handler->handle($request);
        
        // 获取返回内容
        $body = $reponse->getBody()->getContents();
        $json_body = json_decode($body, true);
        // 组装返回格式
        $response_json = json_encode([
            'code' => 200,
            'message' => 'success',
            'data' => $json_body? $json_body : $body
        ], JSON_UNESCAPED_UNICODE);
       
        return $reponse->withAddedHeader('Content-Type', 'application/json')->withBody(new SwooleStream($response_json));
    }
}
