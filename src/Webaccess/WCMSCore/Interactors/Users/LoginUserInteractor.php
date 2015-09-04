<?php

namespace Webaccess\WCMSCore\Interactors\Users;

class LoginUserInteractor extends GetUserInteractor
{
    public function run($userLogin, $userPassword)
    {
        if ($user = $this->getUserByLogin($userLogin)) {
            return self::encrypt($userPassword) == $user->getPassword();
        }

        return false;
    }

    private function encrypt($string)
    {
        return sha1($string);
    }
}
