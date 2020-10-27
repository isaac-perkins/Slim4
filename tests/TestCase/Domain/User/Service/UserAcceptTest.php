<?php
declare(strict_types=1);

namespace Nerd\Domain\User\Service;

use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;

use Nerd\Domain\User\Repository\Model\User;

class UserAcceptService
{
    public static function accept() : int
    {
        try {

            if (Sentinel::authenticate($credentials)) {

                return 0;
            }

            return 401;

        } catch (ThrottlingException $e) {

            return 429;
        }
    }
}
