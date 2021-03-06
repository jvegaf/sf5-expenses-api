<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Repository\GroupRepository;
use App\Repository\UserRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;

class TestBase extends TestCase
{
    /** @var ObjectProphecy|UserRepository */
    protected $userRepositoryProphecy;

    protected UserRepository $userRepository;

    /** @var ObjectProphecy|GroupRepository */
    protected $groupRepositoryProphecy;

    protected GroupRepository $groupRepository;

    public function setUp(): void
    {
        $this->userRepositoryProphecy = $this->prophesize(UserRepository::class);
        $this->userRepository = $this->userRepositoryProphecy->reveal();

        $this->groupRepositoryProphecy = $this->prophesize(GroupRepository::class);
        $this->groupRepository = $this->groupRepositoryProphecy->reveal();
    }
}
