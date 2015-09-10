<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\User;
use Webaccess\WCMSCore\Interactors\Users\DeleteUserInteractor;

class DeleteUserInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new DeleteUserInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingUser()
    {
        $this->interactor->run(1);
    }

    public function testDeleteUser()
    {
        $this->createSampleUser();

        $this->assertCount(1, Context::get('user_repository')->findAll());

        $this->interactor->run(1);

        $this->assertCount(0, Context::get('user_repository')->findAll());
    }

    private function createSampleUser()
    {
        $user = new User();
        $user->setID(1);
        $user->setLastName('User lastname');
        Context::get('user_repository')->createUser($user);
    }
}
