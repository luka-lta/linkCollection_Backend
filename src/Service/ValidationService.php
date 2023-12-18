<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Service;

use LinkCollectionBackend\Exception\ValidationFailureException;

class ValidationService
{
    public function validateUrl(string $url): bool
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return false;
        }
        return true;
    }

    /**
     * @throws ValidationFailureException
     */
    public function validateString(string $string): bool
    {
        if (strlen($string) < 1) {
            throw new ValidationFailureException('String cannot be empty');
        }

        if (strlen($string) > 255) {
            throw new ValidationFailureException('String cannot be longer than 255 characters');
        }

        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $string)) {
            throw new ValidationFailureException('String cannot contain special characters');
        }

        return true;
    }
}