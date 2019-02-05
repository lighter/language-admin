<?php

namespace App\Repositories;

use App\Model\User;
use Illuminate\Database\QueryException;

/**
 * Class UserRepository
 *
 * @property User model
 * @package App\Repositories
 */
class UserRepository
{
    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user) {
        $this->model = $user;
    }

    /**
     * @param $userData
     *
     * @return mixed
     */
    public function createNewUser($userData) {
        try {
            return $this->model->create($userData);
        } catch (QueryException $e) {

        }
    }

    /**
     * @param $userId
     *
     * @return mixed
     */
    public function getUserProjects($userId)
    {
        try {
            return $this->model->where('id', $userId)->projects()->get();
        } catch (QueryException $e) {

        }
    }

    /**
     * @param $userId
     * @param $projectId
     *
     * @return mixed
     */
    public function getUserProject($userId, $projectId)
    {
        try {
            return $this->model->where('id', $userId)->projects->filter(function ($projects) use ($projectId) {
                return $projects->id == $projectId;
            })->first();
        } catch (QueryException $e) {

        }
    }

    /**
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getUsers()
    {
        try {
            return $this->model->all();
        } catch (QueryException $e) {

        }
    }

    /**
     * @param $userId
     * @param $projectId
     *
     * @return mixed
     */
    public function getUserProjectLanguage($userId, $projectId)
    {
        try {
            return $this->model->where('id', $userId)
                ->projects->where('id', $projectId)->first()
                ->languages;
        } catch (QueryException $e) {

        }
    }

    /**
     * @param $userId
     *
     * @return mixed
     */
    public function getUser($userId)
    {
        try {
            return $this->model->where('id', $userId)->first();
        } catch (QueryException $e) {

        }
    }

    /**
     * @param $userId
     * @param $data
     *
     * @return array
     */
    public function updateUser($userId, $data)
    {
        try {
            $user = $this->model->where('id', $userId)->first();

            if (!empty($data['name']) && $data['name'] != $user->name) $user->name = $data['name'];
            if (!empty($data['email']) && $data['email'] != $user->email) $user->email = $data['email'];
            if (!empty($data['password'])) $user->password = bcrypt($data['password']);

            $user->save();

            return [
                'status' => true,
                'data' => $user,
            ];

        } catch (QueryException $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
