<?php

declare(strict_types=1);

namespace App\Exception\Group;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserNotMemberOfGroupException extends BadRequestHttpException
{
    private const MESSAGE = 'User not member of this group';

    public static function create(): self
    {
        throw new self(self::MESSAGE);
    }
}
