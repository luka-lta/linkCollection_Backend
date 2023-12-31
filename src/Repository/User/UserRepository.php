<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Repository\User;

use LinkCollectionBackend\Exception\DatabaseErrorException;
use LinkCollectionBackend\Value\User;
use PDO;
use PDOException;

class UserRepository
{
    public function __construct(
        private readonly PDO $database
    )
    {
    }

    /**
     * @throws DatabaseErrorException
     */
    public function createUser(User $user): void
    {
        $sql = <<<SQL
            INSERT INTO `link_user` (`username`, `email`, `password_hash`) VALUES (:username, :email, :passwordHash);
        SQL;
        try {
            $statement = $this->database->prepare($sql);
            $statement->execute([
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'passwordHash' => $user->getPasswordHash()
            ]);
        } catch (PDOException $exception) {
            throw new DatabaseErrorException('Could not create new user', 0, $exception);
        }
    }
}