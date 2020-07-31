<?php

declare(strict_types=1);

namespace App\Api\Listener\Group;

use App\Api\Listener\PreWriteListener;
use App\Entity\Group;
use App\Entity\User;
use App\Exception\Group\CanNotAddAnotherOwnerException;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class GroupPreWriteListener implements PreWriteListener
{
    private TokenStorageInterface $tokenStorage;
    private const POST_GROUP = 'api_groups_post_collection';

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function onKernelView(ViewEvent $event): void
    {
        /** @var User $tokenUser */
        $tokenUser = $this->tokenStorage->getToken()->getUser();
        $request = $event->getRequest();

        if (self::POST_GROUP === $request->get('_route')) {
            /** @var Group $group */
            $group = $event->getControllerResult();

            if (!$group->isOwnedBy($tokenUser)) {
                throw CanNotAddAnotherOwnerException::create();
            }

            $group->addUser($tokenUser);
        }
    }
}
