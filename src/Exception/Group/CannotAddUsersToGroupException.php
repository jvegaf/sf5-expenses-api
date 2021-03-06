<?php

declare(strict_types=1);

namespace App\Exception\Group;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CannotAddUsersToGroupException extends BadRequestHttpException
{
    private const MESSAGE = 'You cannot add users to this group';

    public static function create(): self
    {
        throw new self(self::MESSAGE);
    }
}
