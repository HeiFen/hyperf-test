<?php

declare(strict_types=1);

namespace App\Controller\Users;

use App\Exception\Exception\ApiException;
use App\Log;
use App\Model\User;
use Exception;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Phper666\JWTAuth\JWT;
use Phper666\JWTAuth\Util\JWTUtil;

use function Swoole\Coroutine\Http\request;

class UsersController
{
    #[Inject]
    protected JWT $jwt;

    /**
     * @Description: 登录
     * @param RequestInterface $request  
     * @return *
     * @Author: LCY
     */
    public function login(RequestInterface $request)
    {
        $user = User::first();
        $token = $this->jwt->getToken('default', [
            'id' => $user->id
        ]);
        
        return [
            'token' => $token->toString(),
            'exp' => $this->jwt->getTTL($token->toString()),
        ];
    }

    public function logout()
    {
        $this->jwt->logout();
    }

    public function info(RequestInterface $request)
    {
        $jwt_data = JWTUtil::getParserData($request);

        // 查询用户信息
        $user = User::where('id', $jwt_data['id'])->first();

        return $user;
    }
}
