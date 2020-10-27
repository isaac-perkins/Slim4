<?php
declare(strict_types=1);

namespace Nerd\Domain\User\Service;

use Nerd\Domain\User\Repository\Model\User;

class UserInviteService
{
    function __construct(UserModel $userModel)
    {

    }

    public function invite()
    {
        //Send email to invite a new user
        //public function invite($locale, $mailer, $invite, $data) : array      
        $user        = new \StdClass;
        $user->name  = $data['name'];
        $user->email = $data['email'];

        try {

            $mailer->sendMessage('Emails/' . $locale . '/invite.twig', ['user' => $user, 'invite' => $invite], function ($message) use ($user) {
                $message->setTo($user->email, $user->name);
                $message->setSubject('Welcome to the Team!');
            });

            $rv = Message::format(200, 'email_sent');

        } catch (\Exception $e) {

            $rv = Message::format(500, 'email_error', ['exception' => $e->getMessage()]);
        }

    return $rv;

    }
}
