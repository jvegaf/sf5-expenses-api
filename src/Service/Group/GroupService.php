<?php

declare(strict_types=1);

namespace App\Service\Group;

use App\Entity\Group;
use App\Entity\User;
use App\Exception\Group\CannotManageGroupException;
use App\Exception\Group\GroupDoesNotExistException;
use App\Exception\Group\UserNotMemberOfGroupException;
use App\Exception\User\UserAlreadyMemberOfGroupException;
use App\Exception\User\UserDoesNotExist;
use App\Repository\GroupRepository;
use App\Repository\UserRepository;

class GroupService
{
    private GroupRepository $groupRepository;

    private UserRepository $userRepository;

    public function __construct(GroupRepository $groupRepository, UserRepository $userRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->userRepository = $userRepository;
    }

    public function addUserToGroup(string $groupId, string $userId, User $user): void
    {
        $group = $this->getGroupFromId($groupId);

        $this->userCanManageGroup($user, $group);

        $userToAdd = $this->getUserFromId($userId);

        if ($this->groupRepository->userIsMember($group, $userToAdd)) {
            throw UserAlreadyMemberOfGroupException::fromUserId($userId);
        }

        $group->addUser($userToAdd);

        $this->groupRepository->save($group);
    }

    public function removeUserFromGroup(string $groupId, string $userId, User $user): void
    {
        $group = $this->getGroupFromId($groupId);

        $this->userCanManageGroup($user, $group);

        $userToRemove = $this->getUserFromId($userId);

        if (!$this->groupRepository->userIsMember($group, $userToRemove)) {
            throw UserNotMemberOfGroupException::create();
        }

        $group->removeUser($userToRemove);

        $this->groupRepository->save($group);
    }

    private function getGroupFromId(string $groupId): Group
    {
        if (null !== $group = $this->groupRepository->findOneById($groupId)) {
            return $group;
        }

        throw GroupDoesNotExistException::fromGroupId($groupId);
    }

    private function userCanManageGroup(User $user, Group $group): void
    {
        if (!$this->groupRepository->userIsMember($group, $user)) {
            throw CannotManageGroupException::create();
        }
    }

    private function getUserFromId(string $userId): User
    {
        if (null !== $user = $this->userRepository->findOneById($userId)) {
            return $user;
        }

        throw UserDoesNotExist::fromUserId($userId);
    }
}
