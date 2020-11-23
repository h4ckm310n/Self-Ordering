<?php
declare(strict_types=1);

use App\Domain\Dish\DishRepository;
use App\Domain\Order\OrderRepository;
use App\Domain\Review\ReviewRepository;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\Dish\InMemoryDishRepository;
use App\Infrastructure\Persistence\Order\InMemoryOrderRepository;
use App\Infrastructure\Persistence\Review\InMemoryReviewRepository;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
        DishRepository::class => \DI\autowire(InMemoryDishRepository::class),
        OrderRepository::class => \DI\autowire(InMemoryOrderRepository::class),
        ReviewRepository::class => \DI\autowire(InMemoryReviewRepository::class)
    ]);
};
