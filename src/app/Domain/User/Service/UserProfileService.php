<?php
declare(strict_types=1);

namespace Nerd\Domain\User\Service;

use Cartalyst\Sentinel\Native\Facades\Sentinel;

use Nerd\Validation\Entity\Profile;
use Nerd\Domain\User\Repository\Model\User;

class UserProfileService
{
    public static function getProfile()
    {
        return User::getProfile(Sentinel::getUser());
    }

    public static function setProfile(Profile $profile)
    {
        $validation = Validator::validate($profile);
        if(!$validation === true) {
            return $validation;
        }
        return User::getProfile(Sentinel::getUser());
    }
}
