<?php

namespace App\Test\TestCase\Domain\User\Service;

use Slim\Views\Twig;
use Mailjet\Client as MailjetClient;
use PHPUnit\Framework\TestCase;
use App\Test\TestCase\UnitTestTrait;
use App\Domain\User\Data\UserCreatorData;
use App\Domain\User\Service\UserActivate;
use App\Utility\Email;


/**
 * Tests.
 */
class UserActivateTest extends TestCase
{

    use UnitTestTrait;

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
     * Create user activate instance.
     *
     * @return UserActivate The instance
     */
    protected function createUserActivateInstance(): UserActivate
    {
        $this->setUp();

        $email = new Email($this->createTwigInstance(), $this->createMailInstance());

        return new UserActivate($email, [
              'Email' => "hi@vpn.webanet.com.au",
              'Name' => "Webanet VPN Australia"
          ]);
    }

    /**
     * Test Activate.
     *
     * @return void
     */
    public function testActivate(): void
    {
        $activate = $this->createUserActivateInstance();

        $user = new UserCreatorData([
            'email' => 'isaac.perkins.1@gmail.com',
            'activation' => sha1(mt_rand(10000,99999).time().'isaac.perkins.1@gmail.com')
        ]);
        
        $activate = $activate->activate($user);

        static::assertSame(true, $activate);
    }
}
