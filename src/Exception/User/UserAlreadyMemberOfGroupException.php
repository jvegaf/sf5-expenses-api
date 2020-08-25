<?php

declare(strict_types=1);

namespace App\Exception\User;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class UserAlreadyMemberOfGroupException extends ConflictHttpException
{
    private const MESSAGE = 'User with id %s is already member of the group';

    public static function fromUserId(string $id): self
    {
        throw new self(\sprintf(self::MESSAGE, $id));
    }
}
