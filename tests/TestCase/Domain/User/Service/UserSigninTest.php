<?php
declare(strict_types=1);

namespace Nerd\Test\TestCase;

use Slim\Views\Twig;
use PHPUnit\Framework\TestCase;

use Nerd\Test\TestCase\UnitTestTrait;
use Nerd\Test\TestCase\ContainerTestTrait;
use Nerd\Domain\User\Service\UserSigninService;
use App\Validation\Validator;

session_start();


class UserSigninTest extends TestCase
{

      use UnitTestTrait;

      /**
       * Create user creator instance.
       *
       * @return Twig The instance
       */
      //protected function createTwigInstance(): Twig
      //{
      //    return $this->getContainer()->get(Twig::class);
      //}


      /**
       * Test Onboard
       *
       * @return void
       */
      public function testOnboard(): void
      {

          $this->setUp();


          //finish
          $this->tearDown();
      }
  }
