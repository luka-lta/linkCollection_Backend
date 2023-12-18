<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Action;

use Psr\Http\Message\ResponseInterface;

abstract class AbstractActionHandler
{
    protected function buildResponse(
        ResponseInterface $response,
        array             $message,
    ): ResponseInterface
    {
        $response->getBody()->write(json_encode($message));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', '*')
            ->withHeader('Access-Control-Max-Age', '86400')
            ->withStatus($message['statusCode']);
    }
}