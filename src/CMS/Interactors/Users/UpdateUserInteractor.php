<?php

namespace CMS\Interactors\Users;

use CMS\Repositories\UserRepositoryInterface;
use CMS\Structures\UserStructure;
use CMS\UseCases\Users\UpdateUserUseCase;

class UpdateUserInteractor extends GetUserInteractor implements UpdateUserUseCase
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        parent::__construct($userRepository);
    }

    public function run($userID, UserStructure $userStructure)
    {
        if ($userStructure->login === '')
            throw new \Exception('You must provide a login for a user');

        if ($this->getByID($userID)) {
            $this->userRepository->updateUser($userID, $userStructure);
        }
    }

}