<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Repository\Page;

use LinkCollectionBackend\Exception\DatabaseErrorException;
use LinkCollectionBackend\Exception\PageNotFoundException;
use LinkCollectionBackend\Value\PageObject;
use PDO;
use PDOException;

class PageObjectRepository
{
    public function __construct(
        private readonly PDO $database,
    )
    {
    }

    /**
     * @throws DatabaseErrorException
     */
    public function createNewPage(PageObject $page): void
    {
        $sql = <<<SQL
            INSERT INTO link_page (owner_id, theme, url_name) VALUES (:ownerId, :theme, :urlName)
        SQL;
        try {
            $statement = $this->database->prepare($sql);
            $statement->execute([
                'ownerId' => $page->getOwnerId(),
                'theme' => $page->getTheme(),
                'urlName' => $page->getUrlName(),
            ]);
        } catch (PDOException $exception) {
            var_dump($exception->getMessage());
            throw new DatabaseErrorException('Could not create new page', 0, $exception);
        }
    }

    /**
     * @throws DatabaseErrorException
     * @throws PageNotFoundException
     */
    // TODO: Implement update route
    public function updatePage(PageObject $page): void
    {
        if (!$this->pageExists($page->getPageId())) {
            throw new PageNotFoundException('Page does not exist');
        }

        $sql = <<<SQL
            UPDATE link_page SET owner_id = :ownerId, theme = :theme, url_name = :urlName WHERE page_id = :pageId
        SQL;
        try {
            $statement = $this->database->prepare($sql);
            $statement->execute([
                'ownerId' => $page->getOwnerId(),
                'theme' => $page->getTheme(),
                'urlName' => $page->getUrlName(),
                'pageId' => $page->getPageId(),
            ]);
        } catch (PDOException $exception) {
            throw new DatabaseErrorException('Could not update page', 0, $exception);
        }
    }

    /**
     * @throws DatabaseErrorException
     */
    public function getPagesFromUser(int $user): array
    {
        $sql = <<<SQL
            SELECT page_id, owner_id, theme, url_name FROM link_page WHERE owner_id = :ownerId
        SQL;
        try {
            $statement = $this->database->prepare($sql);
            $statement->execute([
                'ownerId' => $user
            ]);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            throw new DatabaseErrorException('Could not get pages from user', 0, $exception);
        }

        return $result;
    }

    /**
     * @throws DatabaseErrorException
     */
    public function pageExists(int $pageId): bool
    {
        $sql = <<<SQL
            SELECT COUNT(*) FROM link_page WHERE page_id = :pageId
        SQL;
        try {
            $statement = $this->database->prepare($sql);
            $statement->execute([
                'pageId' => $pageId
            ]);
            $result = $statement->fetchColumn();
        } catch (PDOException $exception) {
            throw new DatabaseErrorException('Could not check if page exists', 0, $exception);
        }

        return $result > 0;
    }
}