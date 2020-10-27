<?php
declare(strict_types=1);

namespace Nerd\Domain\User\Service;

use Nerd\Domain\User\Repository\Model\User;

class UserSignoutService
{
    function __construct(UserModel $userModel)
    {

    }

    public function list()
    {
      return ['id' => 1, 'title' => 'title'];
    }
}
