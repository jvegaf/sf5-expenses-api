<?php


namespace App\Tests\Unit\Api\Action\Group;


use App\Api\Action\Group\AddUser;
use App\Entity\Group;
use App\Entity\User;
use App\Tests\Unit\Api\Action\TestBase;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AddUserTest extends TestBase
{
    private AddUser $action;

    protected function setUp()
    {
        parent::setUp();
        $this->action = new AddUser($this->userRepository, $this->groupRepository);
    }

    public function testCanAddUserToGroup(): void
    {
        $payload = [
            'group_id' => 'group_id_123',
            'user_id' => 'user_id_123',
        ];

        $user = new User('user', 'user@api.com',);
        try {
            $group = new Group('group', $user);
        } catch (\Exception $e) {
        }
        $newUser = new User('new user', 'new@api.com');

        $request = new Request([], [], [], [], [], [], json_encode($payload));
        $this->groupRepositoryProphecy->findOneById($payload['group_id'])->willReturn($group);
        $this->groupRepositoryProphecy->userIsMember($group, $user)->willReturn(true);
        $this->userRepositoryProphecy->findOneById($payload['user_id'])->willReturn($newUser);
        $this->groupRepositoryProphecy->userIsMember($payload['user_id'])->willReturn(false);

        $this->groupRepositoryProphecy->save(
            Argument::that(
                function (Group $group): bool {
                    return true;
                }
            )
        )->shouldBeCalledOnce();

        $response = $this->action->__invoke($request, $user);
        $this->assertEquals(JsonResponse::HTTP_OK , $response->getStatusCode());
    }
}