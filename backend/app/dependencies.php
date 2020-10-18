<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get('settings');

            $loggerSettings = $settings['logger'];
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },

        PDO::class => function (ContainerInterface $c) {
            $settings = $c->get('settings')['db'];
            $driver = $settings['driver'];
            $host = $settings['host'];
            $username = $settings['username'];
            $password = $settings['password'];
            $database = $settings['database'];
            $flags = $settings['flags'];
            $dsn = "$driver:host=$host;dbname=$database";

            return new PDO($dsn, $username, $password, $flags);
        }
    ]);
};
