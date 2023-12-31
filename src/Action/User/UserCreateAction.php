<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Action\User;

use LinkCollectionBackend\Action\AbstractActionHandler;
use LinkCollectionBackend\Service\User\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserCreateAction extends AbstractActionHandler
{
    public function __construct(
        private UserService $userService,
    )
    {
    }

    public function handleUserCreateAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $message = $this->userService->createUser($request->getParsedBody());
        return $this->buildResponse($response, $message);
    }
}