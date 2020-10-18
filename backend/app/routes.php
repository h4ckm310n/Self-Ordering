<?php
declare(strict_types=1);

use App\Application\Actions\Dish\DishDetailAction;
use App\Application\Actions\Dish\ListCategoriesAction;
use App\Application\Actions\Dish\ListDishesAction;
use App\Application\Actions\Dish\ListDishesByCatAction;
use App\Application\Actions\Order\ListOrdersAction;
use App\Application\Actions\Order\OrderDetailAction;
use App\Application\Actions\Order\SubmitOrderAction;
use App\Application\Actions\User\UserLoginAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Middleware\WeappMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/user', function (Group $group) {
        $group->get('/view', ViewUserAction::class);
        $group->post('/login', UserLoginAction::class)->add(WeappMiddleware::class);
    });

    $app->group('/dishes', function (Group $group) {
        $group->get('/categories', ListCategoriesAction::class);
        $group->get('/category/{cat_id}', ListDishesByCatAction::class);
        $group->get('/{dish_id}', DishDetailAction::class);
    });

    $app->group('/orders', function (Group $group) {
        $group->get('/', ListOrdersAction::class);
        $group->post('/submit', SubmitOrderAction::class);
        $group->get('/detail/{order_id}', OrderDetailAction::class);
    });
};
