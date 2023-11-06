<?php

declare(strict_types=1);

namespace App\Controller\Users;

use App\Exception\Exception\ApiException;
use App\Log;
use App\Model\User;
use Exception;
use Hyperf\Context\Context;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Hyperf\Validation\ValidationException;
use Phper666\JWTAuth\JWT;
use Phper666\JWTAuth\Util\JWTUtil;

use function Swoole\Coroutine\Http\request;

class UsersController
{
    #[Inject]
    protected JWT $jwt;

    #[Inject]
    protected ValidatorFactoryInterface $validate;

    /**
     * @Description: 注册
     * @param RequestInterface $request  
     * @return *
     * @Author: LCY
     */    
    public function register(RequestInterface $request, JWT $jwt)
    {
        // 验证
        $validate_result = $this->validate->make($request->all(), [
            'phone' => 'required|integer|unique:users',
            'name' => 'required',
            'password' => 'required'
        ]);
        if ($validate_result->fails()) {
            throw new ValidationException($validate_result);
        }
        
        // 注册
        $user = User::create(array_merge($request->inputs(['phone', 'name']), [
            'uuid' => uniqid(),
            'password' => password_hash($request->input('password'), PASSWORD_DEFAULT)
        ]));

        // 登录
        $token = $jwt->getToken('default', [
            'id' => $user->id
        ]);

        return [
            'token' => $token->toString(),
            'exp' => $jwt->getTTL($token->toString()),
        ];
    }

    /**
     * @Description: 登录
     * @param RequestInterface $request  
     * @return *
     * @Author: LCY
     */
    public function login(RequestInterface $request)
    {
        // 验证
        $validate_result = $this->validate->make($request->all(), [
            'phone' => 'required|integer',
            'password' => 'required'
        ]);
        if ($validate_result->fails()) {
            throw new ValidationException($validate_result);
        }

        $user = User::where('phone', $request->input('phone'))->first();
        if (is_null($user)) {
            throw new ApiException("用户名或密码不正确");
        }
        // 验证密码
        if (!password_verify($request->input('password'), $user->password)) {
            throw new ApiException("用户名或密码不正确");
        }

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
