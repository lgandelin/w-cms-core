<?php

namespace CMS\Interactors\Users;

use CMS\Repositories\UserRepositoryInterface;

class GetUserInteractor
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getByID($userID)
    {
        $userStructure = $this->userRepository->findByID($userID);

        if (!$userStructure)
            throw new \Exception('The user was not found');

        return $userStructure;
    }

}