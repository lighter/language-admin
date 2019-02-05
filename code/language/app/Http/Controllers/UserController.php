<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsers()
    {
        $users = $this->userRepository->getUsers();

        return response()->json(['data' => $users], Response::HTTP_OK);
    }

    /**
     * @param $userId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser($userId)
    {
        $user = $this->userRepository->getUser($userId);

        return response()->json(['data' => $user], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param         $userId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUser(Request $request, $userId)
    {
        $this->_updateUserValidator($request->all())->validate();

        $updateResult = $this->userRepository->updateUser($userId, $request->all());

        return response()->json(['data' => $updateResult], Response::HTTP_OK);
    }

    /**
     * @param $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function _updateUserValidator($data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $data['id'],
            'password' => 'string|min:6|confirmed',
        ]);
    }
}
