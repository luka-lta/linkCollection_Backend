<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Repository;

class EnvironmentRepository
{
    public function get(string $key): string|false
    {
        $value = getenv($key);
        if ($value === false) {
            return false;
        }

        return $value;
    }
}