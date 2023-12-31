<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Route;

use LinkCollectionBackend\Action\Link\LinkCreateAction;
use LinkCollectionBackend\Action\Link\LinkDeleteAction;
use LinkCollectionBackend\Action\Link\LinkGetAction;
use LinkCollectionBackend\Action\Link\LinkUpdateAction;
use LinkCollectionBackend\Action\Page\PageCreateAction;
use LinkCollectionBackend\Action\Page\PagesFromUserAction;
use LinkCollectionBackend\Action\StatsAction;
use LinkCollectionBackend\Action\User\UserCreateAction;
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

            $group->group('/pages', function (RouteCollectorProxy $pages) {
                $pages->put('', [PageCreateAction::class, 'handlePageCreateAction']);
                $pages->get('', [PagesFromUserAction::class, 'handleGetPagesFromUserAction']);
//                $pages->get('', [LinkGetAction::class, 'handleLinkGetAction']);
//                $pages->post('', [LinkUpdateAction::class, 'handleLinkUpdateAction']);
//                $pages->delete('', [LinkDeleteAction::class, 'handleLinkDeleteAction']);
//                $pages->get('/stats', [StatsAction::class, 'handleStatsAction']);
            });

            $group->group('/users', function (RouteCollectorProxy $users) {
               $users->put('', [UserCreateAction::class, 'handleUserCreateAction']);
            });
        });
    }
}