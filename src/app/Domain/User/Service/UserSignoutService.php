<?php
declare(strict_types=1);

namespace Nerd\Domain\User\Service;

use Cartalyst\Sentinel\Native\Facades\Sentinel;

class UserSignoutService
{
    public static function signout(): void
    {
        try {
            Sentinel::logOut();
        } catch(\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
