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

use App\Exception\Exception\ApiException;
use App\Model\User;
use App\Request\UserRequest;

class IndexController extends AbstractController
{
    public function index(UserRequest $rqeuest)
    {
        $user = User::find($rqeuest->input('id'));

        if (is_null($user)) {
            throw new ApiException("用户不存在");
        }

        return $user;
    }
}
