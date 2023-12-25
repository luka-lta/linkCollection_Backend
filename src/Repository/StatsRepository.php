<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Repository;

use LinkCollectionBackend\Exception\DatabaseErrorException;
use PDO;
use PDOException;

class StatsRepository
{
    public function __construct(
        private readonly PDO $database
    )
    {
    }

    /**
     * @throws DatabaseErrorException
     */
    public function getStats(): array
    {
        $sql = <<<SQL
            SELECT COUNT(*) AS totalLinks FROM link_list
        SQL;
        try {
            $statement = $this->database->prepare($sql);
            $statement->execute();
            return $statement->fetchAll();
        } catch (PDOException $exception) {
            throw new DatabaseErrorException('Could not fetch stats', 0, $exception);
        }
    }
}