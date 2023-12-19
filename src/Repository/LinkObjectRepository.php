<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Repository;

use LinkCollectionBackend\Exception\DatabaseErrorException;
use LinkCollectionBackend\Exception\LinkNotFoundException;
use LinkCollectionBackend\Value\LinkObject;
use PDO;
use PDOException;

class LinkObjectRepository
{
    public function __construct(
        private readonly PDO $database
    )
    {}

    /**
     * @throws DatabaseErrorException
     */
    public function getAllLinks(): array
    {
        $sql = <<<SQL
            SELECT * FROM link_list
        SQL;
        try {
            $statement = $this->database->prepare($sql);
            $statement->execute();
            return $statement->fetchAll();
        } catch (PDOException $exception) {
            throw new DatabaseErrorException('Could not fetch links', 0, $exception);
        }
    }

    /**
     * @throws DatabaseErrorException
     */
    public function createNewLink(LinkObject $linkObject): void
    {
        $sql = <<<SQL
            INSERT INTO link_list (name, url, displayname) VALUES (:name, :url, :displayname)
        SQL;
        try {
            $statement = $this->database->prepare($sql);
            $statement->execute([
                'name' => $linkObject->getName(),
                'url' => $linkObject->getUrl(),
                'displayname' => $linkObject->getDisplayName()
            ]);
        } catch (PDOException $exception) {
            throw new DatabaseErrorException('Could not create new link', 0, $exception);
        }
    }

    /**
     * @throws DatabaseErrorException
     * @throws LinkNotFoundException
     */
    public function deleteLink(int $linkId): void
    {
        if (!$this->existsLink($linkId)) {
            throw new LinkNotFoundException('Link does not exist');
        }

        $sql = <<<SQL
            DELETE FROM link_list WHERE id = :linkId
        SQL;
        try {
            $statement = $this->database->prepare($sql);
            $statement->execute([
                'linkId' => $linkId
            ]);
        } catch (PDOException $exception) {
            throw new DatabaseErrorException('Could not delete link', 0, $exception);
        }
    }

    /**
     * @throws DatabaseErrorException
     * @throws LinkNotFoundException
     */
    public function updateLink(LinkObject $linkObject): void
    {
        if (!$this->existsLink($linkObject->getLinkId())) {
            throw new LinkNotFoundException('Link does not exist');
        }

        $sql = <<<SQL
            UPDATE link_list SET name = :name, url = :url, displayname = :displayname WHERE id = :linkId
        SQL;
        try {
            $statement = $this->database->prepare($sql);
            $statement->execute([
                'name' => $linkObject->getName(),
                'url' => $linkObject->getUrl(),
                'displayname' => $linkObject->getDisplayName(),
                'linkId' => $linkObject->getLinkId()
            ]);
        } catch (PDOException $exception) {
            throw new DatabaseErrorException('Could not update link', 0, $exception);
        }
    }

    public function existsLink(int $linkId): bool
    {
        $sql = <<<SQL
            SELECT * FROM link_list WHERE id = :linkId
        SQL;
        $statement = $this->database->prepare($sql);
        $statement->execute([
            'linkId' => $linkId
        ]);
        $result = $statement->fetch();
        return !empty($result);
    }
}