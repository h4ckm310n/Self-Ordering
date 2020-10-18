<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;


class WeappMiddleware implements Middleware
{
    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $appid = 'wx2ec19f6dd5a52d16';
        $appsecret = '1ace8d51192aa0eb593655e5de3f892e';
        $request = $request->withAttributes(['appid' => $appid, 'appsecret' => $appsecret]);

        return $handler->handle($request);
    }
}
