<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\User;
use Webaccess\WCMSCore\Interactors\Users\GetUsersInteractor;
use Webaccess\WCMSCore\DataStructure;

class GetUsersInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new GetUsersInteractor();
    }

    public function testGetAllWithoutUsers()
    {
        $this->assertCount(0, $this->interactor->getAll());
    }

    public function testGetAll()
    {
        $this->createSampleUser(1);
        $this->createSampleUser(2);

        $users = $this->interactor->getAll();

        $this->assertCount(2, $users);
        $this->assertInstanceOf('\Webaccess\WCMSCore\Entities\User', array_shift($users));
    }

    public function testGetByStructures()
    {
        $this->createSampleUser(1);
        $this->createSampleUser(2);

        $users = $this->interactor->getAll(true);

        $this->assertCount(2, $users);
        $this->assertEquals(new DataStructure([
            'ID' => 1,
            'login' => null,
            'password' => null,
            'last_name' => 'User lastname',
            'first_name' => null,
            'email' => null,
        ]), array_shift($users));
    }

    private function createSampleUser($userID)
    {
        $user = new User();
        $user->setID($userID);
        $user->setLastName('User lastname');
        Context::get('user_repository')->createUser($user);

        return $user;
    }
}
