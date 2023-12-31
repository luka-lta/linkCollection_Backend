<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Service\User;

use LinkCollectionBackend\Exception\InvalidBodyDataException;
use LinkCollectionBackend\Exception\LinkCollectionException;
use LinkCollectionBackend\Exception\ValidationFailureException;
use LinkCollectionBackend\Repository\User\UserRepository;
use LinkCollectionBackend\Service\AbstractActionService;
use LinkCollectionBackend\Service\ValidationService;
use LinkCollectionBackend\Value\User;

class UserService extends AbstractActionService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly ValidationService $validationService
    )
    {
    }

    public function createUser(array $payload): array
    {
        $message = 'User created';
        $code = 201;
        try {
            $userObject = $this->createUserObject($payload);
            $this->userRepository->createUser($userObject);
        } catch (LinkCollectionException $exception) {
            $message = $exception->getMessage();
            $code = 500;
        }

        return $this->createResponseMessage($message, $code);
    }

    /**
     * @throws InvalidBodyDataException
     * @throws ValidationFailureException
     */
    public function createUserObject(array $payload): User
    {
        if (!isset($payload['username'])) {
            throw new InvalidBodyDataException('Username is required');
        }

        if (!isset($payload['email'])) {
            throw new InvalidBodyDataException('Email is required');
        }

        if (!isset($payload['password'])) {
            throw new InvalidBodyDataException('Password is required');
        }

        if (!$this->validationService->validateString($payload['username'])) {
            throw new InvalidBodyDataException('Username is invalid');
        }

        if (!$this->validationService->validateEmail($payload['email'])) {
            throw new InvalidBodyDataException('Email is invalid');
        }

        // TODO: Validate Password

        $userObject =  User::fromPayload($payload);

        $hashedPassword = password_hash($payload['password'], PASSWORD_BCRYPT);
        $userObject->setPasswordHash($hashedPassword);
        return $userObject;
    }
}