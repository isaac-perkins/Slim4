<?php
declare(strict_types=1);

namespace Nerd\Domain\User\Service;

use Nerd\Domain\User\Repository\Model\User;

class UserSignupService
{
    function __construct(UserModel $userModel)
    {

    }

    public function signup()
    {
      return ['id' => 1, 'title' => 'title'];
    }
}
