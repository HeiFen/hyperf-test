<?php
namespace App\Exception\Handler;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Phper666\JWTAuth\Exception\JWTException;
use Phper666\JWTAuth\Exception\TokenValidException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ApiExceptionHandler extends  ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        // 捕获验证异常
        if ($throwable instanceof \Hyperf\Validation\ValidationException) {
            // 格式化输出
            $data = json_encode([
                'code' => $throwable->status,
                'message' => $throwable->validator->errors()->first(),
                'data' => null
            ], JSON_UNESCAPED_UNICODE);

            // 阻止异常冒泡
            $this->stopPropagation();

            // 返回json格式
            return $response->withAddedHeader('Content-Type', 'application/json')
                ->withStatus($throwable->status)
                ->withBody(new SwooleStream($data));
        }

        // 捕获api异常
        if ($throwable instanceof \App\Exception\Exception\ApiException) {
            // 格式化输出
            $data = json_encode([
                'code' => $throwable->getCode(),
                'message' => $throwable->getMessage(),
                'data' => null
            ], JSON_UNESCAPED_UNICODE);
            
            // 阻止异常冒泡
            $this->stopPropagation();
            
            // 返回json格式
            return $response->withAddedHeader('Content-Type', 'application/json')
                ->withStatus(400)
                ->withBody(new SwooleStream($data));
        }

        if ($throwable instanceof TokenValidException) {
            // 格式化输出
            $data = json_encode([
                'code' => $throwable->getCode(),
                'message' => $throwable->getMessage(),
                'data' => null
            ], JSON_UNESCAPED_UNICODE);
            
            // 阻止异常冒泡
            $this->stopPropagation();
            
            // 返回json格式
            return $response->withAddedHeader('Content-Type', 'application/json')
                ->withStatus(400)
                ->withBody(new SwooleStream($data));
        }

        if ($throwable instanceof JWTException) {
            // 格式化输出
            $data = json_encode([
                'code' => $throwable->getCode(),
                'message' => $throwable->getMessage(),
                'data' => null
            ], JSON_UNESCAPED_UNICODE);
            
            // 阻止异常冒泡
            $this->stopPropagation();
            
            // 返回json格式
            return $response->withAddedHeader('Content-Type', 'application/json')
                ->withStatus(400)
                ->withBody(new SwooleStream($data));
        }
        
        // 交给下一个异常处理器
        return $response;

        // 或者不做处理直接屏蔽异常
    }

    /**
     * 判断该异常处理器是否要对该异常进行处理
     */
    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
