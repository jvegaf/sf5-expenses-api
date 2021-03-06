<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Group;

use App\Entity\Group;
use App\Entity\User;
use App\Service\Group\GroupService;
use App\Tests\Unit\TestBase;
use Prophecy\Argument;

class GroupServiceTest extends TestBase
{
    private GroupService $groupService;

    public function setUp(): void
    {
        parent::setUp();

        $this->groupService = new GroupService($this->groupRepository, $this->userRepository);
    }

    public function testAddUserToGroup(): void
    {
        $groupId = 'group_id_123';
        $userId = 'user_id_456';

        $user = new User('user', 'user@api.com');
        $newUser = new User('new', 'new.user@api.com');
        $group = new Group('group', $user);

        $this->groupRepositoryProphecy->findOneById($groupId)->willReturn($group);
        $this->groupRepositoryProphecy->userIsMember($group, $user)->willReturn(true);
        $this->userRepositoryProphecy->findOneById($userId)->willReturn($newUser);
        $this->groupRepositoryProphecy->userIsMember($group, $newUser)->willReturn(false);

        $this->groupRepositoryProphecy->save(
            Argument::that(
                function (Group $group): bool {
                    return true;
                }
            )
        )->shouldBeCalledOnce();

        $this->groupService->addUserToGroup($groupId, $userId, $user);
    }

    public function testRemoveUserFromGroup(): void
    {
        $groupId = 'group_id_123';
        $userId = 'user_id_456';

        $user = new User('user', 'user@api.com');
        $newUser = new User('new', 'new.user@api.com');
        $group = new Group('group', $user);

        $this->groupRepositoryProphecy->findOneById($groupId)->willReturn($group);
        $this->groupRepositoryProphecy->userIsMember($group, $user)->willReturn(true);
        $this->userRepositoryProphecy->findOneById($userId)->willReturn($newUser);
        $this->groupRepositoryProphecy->userIsMember($group, $newUser)->willReturn(true);

        $this->groupRepositoryProphecy->save(
            Argument::that(
                function (Group $group): bool {
                    return true;
                }
            )
        )->shouldBeCalledOnce();

        $this->groupService->removeUserFromGroup($groupId, $userId, $user);
    }
}
