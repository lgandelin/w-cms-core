<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\User;
use Webaccess\WCMSCore\Interactors\Users\LoginUserInteractor;

class LoginUserInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new LoginUserInteractor();
    }

    public function testLogin()
    {
        self::createSampleUser(1);

        $this->assertEquals(true, $this->interactor->run('jdoe', '111aaa'));
        $this->assertEquals(false, $this->interactor->run('jdoe', 'wrongPassword'));
        $this->assertEquals(false, $this->interactor->run('jdoe', ''));
    }

    /**
     * @expectedException Exception
     */
    public function testLoginUserNotFound()
    {
        $this->assertEquals(false, $this->interactor->run('', ''));
        $this->assertEquals(false, $this->interactor->run('', 'password'));
    }

    private static function createSampleUser($userID)
    {
        $user = new User();
        $user->setID($userID);
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setLogin('jdoe');
        $user->setEmail('john.doe@gmail.com');
        $user->setPassword(sha1('111aaa'));
        Context::get('user_repository')->createUser($user);

        return $user;
    }
} 