<?php

namespace App\Test\TestCase\Domain\User\Service;

use Cake\Database\Connection;
use PHPUnit\Framework\TestCase;

use App\Domain\User\Data\UserCreatorData;
use App\Domain\User\Repository\UserGeneratorRepository;
use App\Domain\User\Service\UserCreator;
use App\Domain\User\Service\UserActivator;
use App\Repository\QueryFactory;
use App\Test\TestCase\UnitTestTrait;

/**
 * Tests.
 */
class UserActivatorTest extends TestCase
{

    use UnitTestTrait;
    /**
     * Create user creator instance.
     *
     * @return UserCreator The instance
     */
    protected function createUserCreatorInstance(): UserCreator
    {
        return $this->getContainer()->get(UserCreator::class);
    }

    /**
     * Create user creator instance.
     *
     * @return UserCreator The instance
     */
    protected function createUserActivatorInstance(): UserActivator
    {
        $this->setUp();

        $queryFactory = new QueryFactory($this->getConnection());

        return new UserActivator($queryFactory);
    }
    /**
     * Test.
     *
     * @return void
     */
    public function testActivation(): void
    {
        $service = $this->createUserCreatorInstance();
        $activator = $this->createUserActivatorInstance();

        $activation = sha1(mt_rand(10000,99999).time().'john.doe@example.com');

        $user = new UserCreatorData();
        $user->username = 'john.doe';
        $user->email = 'john.doe@example.com';
        $user->firstName = 'John';
        $user->lastName = 'Doe';
        $user->password = 'testthispassword';
        $user->payment_method = 1;
        $user->payment_id = 'asdffdsa';
        $user->plan = 'plan_plan';
        $user->vpn_id = 'asdffdsafdsafd';
        $user->activation = $activation;

        $actual = $service->createUser($user);

        static::assertSame(201, $activator->activate($activation));
        static::assertSame(501, $activator->activate($activation));

        $this->tearDown();
    }
}
