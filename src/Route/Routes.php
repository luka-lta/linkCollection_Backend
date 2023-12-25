<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Route;

use LinkCollectionBackend\Action\LinkCreateAction;
use LinkCollectionBackend\Action\LinkDeleteAction;
use LinkCollectionBackend\Action\LinkGetAction;
use LinkCollectionBackend\Action\LinkUpdateAction;
use LinkCollectionBackend\Action\StatsAction;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

class Routes
{
    public static function getRoutes(App $app): void
    {
        $app->group('/api/v1', function (RouteCollectorProxy $group) {
            $group->group('/links', function (RouteCollectorProxy $links) {
                $links->put('', [LinkCreateAction::class, 'handleLinkCreateAction']);
                $links->get('', [LinkGetAction::class, 'handleLinkGetAction']);
                $links->post('', [LinkUpdateAction::class, 'handleLinkUpdateAction']);
                $links->delete('', [LinkDeleteAction::class, 'handleLinkDeleteAction']);
                $links->get('/stats', [StatsAction::class, 'handleStatsAction']);
            });
        });
    }
}