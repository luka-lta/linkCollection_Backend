<?php

use DI\Bridge\Slim\Bridge;
use DI\DependencyException;
use DI\NotFoundException;
use LinkCollectionBackend\Factory\ContainerFactory;
use LinkCollectionBackend\Repository\EnvironmentRepository;
use LinkCollectionBackend\Route\Routes;

require __DIR__ . '/../vendor/autoload.php';

$container = ContainerFactory::createContainer();
if ($container === false) {
    echo 'Container could not be created';;
}

$app = Bridge::create($container);

try {
    $environmentRepository = $container->get(EnvironmentRepository::class);
    if ($environmentRepository->get('APP_ENV') === 'development') {
        $app->addErrorMiddleware(true, true, true);
    }
} catch (DependencyException|NotFoundException $e) {
    echo 'EnvironmentRepository could not be created';
}

$app->addBodyParsingMiddleware();
Routes::getRoutes($app);
$app->run();