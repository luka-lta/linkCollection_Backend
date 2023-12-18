<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Factory;

use DI\Container;
use DI\ContainerBuilder;
use Exception;
use PDO;
use function DI\factory;

class ContainerFactory
{
    public static function createContainer(): Container|false
    {
        $containerBuilder = new ContainerBuilder();
        try {
            $containerBuilder->addDefinitions([
                PDO::class  => factory(PdoFactory::class)
            ]);
            $container = $containerBuilder->build();
        } catch (Exception) {
            return false;
        }

        return $container;
    }
}