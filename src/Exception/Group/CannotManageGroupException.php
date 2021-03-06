<?php

declare(strict_types=1);

namespace App\Exception\Group;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CannotManageGroupException extends BadRequestHttpException
{
    private const MESSAGE = 'You cannot manage this group';

    public static function create(): self
    {
        throw new self(self::MESSAGE);
    }
}
