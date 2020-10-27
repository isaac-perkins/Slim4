<?php

namespace App\Test\TestCase\Domain\User\Service;


use Slim\Views\Twig;
use Mailjet\Client as MailjetClient;
use Selective\Config\Configuration;
use PHPUnit\Framework\TestCase;

use App\Test\TestCase\DatabaseTestTrait;
use App\Utility\Email;
use App\Repository\QueryFactory;
use App\Domain\User\Service\UserCreator;
use App\Domain\User\Validator\UserValidator;
use App\Domain\User\Data\UserCreatorData;
use App\Domain\User\Repository\UserVpnRepository;
use App\Domain\User\Repository\UserRepository;
use App\Domain\User\Service\UserOnboard;

/**
 * Tests.
 */
class UserOnboardTest extends TestCase
{

    use DatabaseTestTrait;

    /**
     * Create user creator instance.
     *
     * @return Configuration The instance
     */
    protected function createConfiguration(): Configuration
    {
        return $this->getContainer()->get(Configuration::class);
    }

    /**
     * Create user creator instance.
     *
     * @return UserRepository The instance
     */
    protected function createUserRepositoryInstance(): UserRepository
    {
        $queryFactory = new QueryFactory($this->getConnection());

        return new UserRepository($queryFactory);
    }

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
     * @return Twig The instance
     */
    protected function createTwigInstance(): Twig
    {
        return $this->getContainer()->get(Twig::class);
    }

    /**
     * Create MailjetClient instance.
     *
     * @return MailjetClient The instance
     */
    protected function createMailInstance(): MailjetClient
    {
        return $this->getContainer()->get(MailjetClient::class);
    }

    /**
     * Create instance.
     *
     * @return UserVpnRepository The instance
     */
    protected function createVpnInstance(): UserVpnRepository
    {
        $vpn = $this->createConfiguration()->getArray('vpn');
        return new UserVpnRepository($vpn);
    }

    /**
     * Create user creator instance.
     *
     * @return UserCreator The instance
     */
    protected function createUserOnboardInstance(): UserOnboard
    {
        return new UserOnboard(
            $this->createConfiguration(),
            $this->createUserCreatorInstance(),
            new UserValidator,
            new Email($this->createTwigInstance(), $this->createMailInstance())
        );
    }

    /**
     * Test Onboard
     *
     * @return void
     */
    public function testOnboard(): void
    {
        $this->setUp();

        // test user onboard
        $user = new UserCreatorData();
        $user->username = 'unit_test_user_onboard';
        $user->email = 'isaac.perkins.1@gmail.com';
        $user->password = 'testthispassword';
        $user->paymentMethod = 1;
        $user->paymentId = 'test-payment-id';
        $user->plan = 'test-user-plan';
        $user->enabled = 1;
        $service = $this->createUserOnboardInstance();

        $user = $service->onboardUser($user);

        static::assertSame(true, ($user->id > 0));

        $vpn = $this->createVpnInstance();
        static::assertSame(true, $vpn->remove($user->vpnId));

        //finish
        $this->tearDown();
    }
}
