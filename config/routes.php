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

use App\Controller\IndexController;
use App\Controller\Users\UsersController;
use Hyperf\HttpServer\Router\Router;
use Phper666\JWTAuth\Middleware\JWTAuthDefaultSceneMiddleware;

Router::post('/user/register', [UsersController::class, 'register']); // 注册
Router::post('/user/login', [UsersController::class, 'login']); // 登录

// 需要登录
Router::addGroup('/', function() {

    // 用户相关
    Router::post('user/logout', [UsersController::class, 'logout']); // 退出登录
    Router::post('user/info', [UsersController::class, 'info']); // 详情

}, ['middleware' => [JWTAuthDefaultSceneMiddleware::class]]);

Router::get('/', [IndexController::class, 'index']);