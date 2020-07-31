<?php

declare(strict_types=1);

namespace App\Exception\Group;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CanNotAddAnotherOwnerException extends AccessDeniedHttpException
{
    private const MESSAGE = 'You can not add another user as owner';

    public static function create(): self
    {
        throw new self(self::MESSAGE);
    }
}
