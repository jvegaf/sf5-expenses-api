<?php

declare(strict_types=1);

namespace App\Exception\User;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserDoesNotExist extends BadRequestHttpException
{
    private const MESSAGE = 'User with id %s does not exist';

    public static function fromUserId(string $id): self
    {
        throw new self(\sprintf(self::MESSAGE, $id));
    }
}
