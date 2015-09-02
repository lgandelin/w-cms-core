<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\User;
use Webaccess\WCMSCore\Interactors\Users\UpdateUserInteractor;
use Webaccess\WCMSCore\DataStructure;

class UpdateUserInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new UpdateUserInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingUser()
    {
        $userStructure = new DataStructure([
            'ID' => 1,
            'login' => 'jdoe',
            'last_name' => 'Doe',
            'first_name' => 'John'
        ]);

        $this->interactor->run($userStructure);
    }

    public function testUpdateUser()
    {
        $this->createSampleUser(1);

        $userStructureUpdated = new DataStructure([
            'first_name' => 'Jack'
        ]);

        $this->interactor->run(1, $userStructureUpdated);

        $user = Context::get('user')->findByID(1);

        $this->assertEquals('jdoe', $user->getLogin());
        $this->assertEquals('Doe', $user->getLastName());
        $this->assertEquals('Jack', $user->getFirstName());
        $this->assertEquals('john.doe@gmail.com', $user->getEmail());
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateUserWithEmptyLogin()
    {
        $this->createSampleUser(1);

        $userStructureUpdated = new DataStructure([
            'login' => ''
        ]);

        $this->interactor->run(1, $userStructureUpdated);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateUserWithAnotherUserExistingWithSameLogin()
    {
        $this->createSampleUser(1);

        $user = new User();
        $user->setID(2);
        $user->setLogin('jane.doe');
        Context::get('user')->createUser($user);

        $userStructureUpdated = new DataStructure([
            'login' => 'jdoe'
        ]);

        $this->interactor->run(2, $userStructureUpdated);
    }

    private function createSampleUser($userID)
    {
        $user = new User();
        $user->setID($userID);
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setLogin('jdoe');
        $user->setEmail('john.doe@gmail.com');
        Context::get('user')->createUser($user);

        return $user;
    }
}
