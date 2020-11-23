<?php
declare(strict_types=1);

use App\Application\Middleware\RemoteAddrMiddleware;
use App\Application\Middleware\RequestAuthMiddleware;
use App\Application\Middleware\SessionMiddleware;
use Slim\App;

return function (App $app) {
    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();
    $app->add(RemoteAddrMiddleware::class);
    //$app->add(SessionMiddleware::class);
    $app->add(RequestAuthMiddleware::class);
};
