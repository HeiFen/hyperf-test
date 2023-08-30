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
namespace App\Controller;

use App\Model\User;

use function Swoole\Coroutine\Http\request;

class IndexController extends AbstractController
{
    public function index()
    {
        return User::first()->toArry();
    }
}
