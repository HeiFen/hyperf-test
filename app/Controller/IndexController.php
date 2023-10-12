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
use Hyperf\HttpServer\Contract\RequestInterface;

class IndexController extends AbstractController
{
    public function index(RequestInterface $rqeuest)
    {
        return $rqeuest->all();
    }
}
