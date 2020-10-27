<?php

namespace App\Test\TestCase\Domain\User\Repository;

use App\Domain\User\Repository\UserRepository;
use App\Domain\User\Data\UserCreatorData;
use App\Test\Fixture\UserFixture;
use App\Test\TestCase\DatabaseTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * Tests.
 */
class UserRepositoryTest extends TestCase
{
    use DatabaseTestTrait;

    /**
     * Fixtures.
     *
     * @var array
     */
    public $fixtures = [
        UserFixture::class,
    ];

    /**
     * Create instance.
     *
     * @return UserGeneratorRepository The instance
     */
    protected function createInstance(): UserRepository
    {
        return $this->getContainer()->get(UserRepository::class);
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testFindUser(): void
    {
        $this->setUp();

        $repository = $this->createInstance();

        $actual = $repository->findByUsername('admin');

        static::assertSame(true, ($actual->id === 1));

        $this->tearDown();
    }
}
