<?php

declare(strict_types=1);

namespace App\Api\Action\Group;

use App\Api\Action\RequestTransformer;
use App\Repository\GroupRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AddUser
{

    private UserRepository $userRepository;
    private GroupRepository $groupRepository;

    public function __construct(UserRepository $userRepository, GroupRepository $groupRepository)
    {
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
    }

    /**
     * @Route ("/groups/add_user", methods={"POST"})
     */
    public function __invoke(Request $request, User $user): JsonResponse
    {
        $groupId = RequestTransformer::getRequiredField($request, 'group_id');
        $userId = RequestTransformer::getRequiredField($request, 'user_id');
        $group = $this->groupRepository->findOneById($groupId);

        if ($group === null) {
            throw new BadRequestHttpException('Group not found');
        }

        if (!$this->groupRepository->userIsMember($group, $user)) {
            throw new BadRequestHttpException('You can not add users to this group');
        }

        $newUser = $this->userRepository->findOneById($userId);
        if ($newUser === null) {
            throw new BadRequestHttpException('User not found');
        }

        $group->addUser($newUser);
        $this->groupRepository->save($group);
        return new JsonResponse(
            [
                'message' => sprintf('user %s added to group %s', $userId, $groupId),
            ]
        );
    }
}