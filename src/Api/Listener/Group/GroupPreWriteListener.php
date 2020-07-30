<?php
declare(strict_types=1);


namespace App\Api\Listener\Group;


use App\Api\Listener\PreWriteListener;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

class GroupPreWriteListener implements PreWriteListener
{
    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function onKernelView(ViewEvent $event): void
    {
        // TODO: Implement onKernelView() method.
    }
}