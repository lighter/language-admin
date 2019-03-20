<?php

namespace App\Repositories;


use App\Model\VerifyUser;

/**
 * Class VerifyUserRepository
 *
 * @package App\Repositories
 */
class VerifyUserRepository
{
    /**
     * @var VerifyUser
     */
    private $model;

    /**
     * VerifyUserRepository constructor.
     *
     * @param VerifyUser $verifyUser
     */
    public function __construct(VerifyUser $verifyUser)
    {
        $this->model = $verifyUser;
    }
}
