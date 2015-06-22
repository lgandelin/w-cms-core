<?php

use CMS\Context;
use CMS\Entities\User;
use CMS\Interactors\Users\GetUserInteractor;

class GetUserInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new GetUserInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testGetNonExistingUser()
    {
        $this->interactor->getUserByID(1);
    }

    public function testGetUser()
    {
        $user = $this->createSampleUser();
        
        $this->assertEquals($user, $this->interactor->getUserByID(1));
    }

    private function createSampleUser()
    {
        $user = new User();
        $user->setLastName('User lastname');
        $user->setLogin('User login');
        Context::getRepository('user')->createUser($user);

        return $user;
    }
}
