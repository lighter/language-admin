<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Response;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserProjects()
    {
        $user = \Auth::user();

        $userProjects = $this->userRepository->getUserProjects($user->id);

        return response()->json(['data' => $userProjects], Response::HTTP_OK);
    }
}
