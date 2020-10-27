<?php
declare(strict_types=1);

namespace Nerd\Domain\User\Repository\Model;

use Cartalyst\Sentinel\Hashing\NativeHasher;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Capsule\Manager as Eloquent;

use Nerd\Domain\Job\Repository\Model\Job;
use Symfony\Component\Validator\Constraints as Assert;

class User extends EloquentUser
{
    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'username',
        'email',
        'password',
        'last_name',
        'first_name',
        'permissions',
    ];

    protected $loginNames = ['username', 'email'];




    /*
        Delete a user
    */
    public static function remove(int $id) : array
    {      //Send email to invite a new user
      //public function invite($locale, $mailer, $invite, $data) : array

        try {

            self::destroy($id);

            $rv = 'user_deleted';

        } catch (\Exception $e) {

            $rv = 'remove_user_error';
        }

        return $rv;
    }

    /*
        Get user's profile as array
    */
    public static function getProfile($user) : array
    {
        return [
            'user' => [
                'id'         => $user->id,
                'username'   => $user->username,
                'email'      => $user->email,
                'first_name' => $user->first_name,
                'last_name'  => $user->last_name,
            ],
        ];
    }

    /*
        Edit user det's _+ pwd
    */
    public static function setProfile($user, array $post)
    {
        if (\strlen($post['old_password']) > 0) {
            try {
                self::setPassword(
              $user,
              $post['old_password'],
              $post['new_password'],
              $post['confirm_password']
          );
            } catch (\Exception $e) {
                return Message::format(500, 'Can not update password', ['exception' => $e->getMessage()]);
            }
        }

        if ($user->email !== $post['email']) {
            $user->email = $post['email'];
        }

        $user->first_name = $post['fname'];
        $user->last_name  = $post['lname'];

        $user->save();

        return Message::format(200, 'profile_updated', self::profile($user));
    }

    /*
        Update user password
    */
    public function setPassword($user, string $old, string $new, string $confirm) : void
    {
        if (!NativeHasher::check($old, $user->password) || $new != $confirm) {
            throw new \Exception('Invalid password');
        }

        try {
            $sql = Eloquent::raw('UPDATE "user" ' . "SET password = '" . NativeHasher::hash($new) . "' WHERE id = " . $user->id);

            Eloquent::select($sql);
        } catch (\Exception $e) {
            throw new \Exception('Can not update password. ' . $e->getMessage());
        }
    }


    /*
        Users jobs relationship
    */
    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_users','job_id','user_id');
    }
}
