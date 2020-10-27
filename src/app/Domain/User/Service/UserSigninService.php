<?php
declare(strict_types=1);

namespace Nerd\Domain\User\Service;

use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;

use Nerd\Exception\UnAuthorizedException;
use Nerd\Exception\AttemptsException;
use Nerd\Validation\Entity\Signin;
use Nerd\Validation\Validator;
use Nerd\Action\Payload;

class UserSigninService
{
    public static function signin(Signin $signin): Payload
    {
        //todo csrf

        //Do validation
        $validation = Validator::validate($signin);
        if(!$validation === true) {
            return $validation;
        }

        try {
            //Authenticate user
            if(Sentinel::authenticate([
                'email' => $signin->getEmail(),
                'password' => $signin->getPassword()
            ])) {
                return new Payload(200);
            }

            throw new UnAuthorizedException('401 Authentication failed.');

        } catch (ThrottlingException $e) {
            throw new AttemptsException('429 Too many attempts');
        }
    }
}
