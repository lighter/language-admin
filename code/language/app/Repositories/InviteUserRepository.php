<?php

namespace App\Repositories;

use App\Model\InviteUser;
use Carbon\Carbon;
use Illuminate\Database\QueryException;


/**
 * Class InviteUserRepository
 *
 * @package App\Repositories
 */
class InviteUserRepository
{
    /**
     * @var InviteUser
     */
    private $model;

    /**
     * InviteUserRepository constructor.
     *
     * @param InviteUser $inviteUser
     */
    public function __construct(InviteUser $inviteUser)
    {
        $this->model = $inviteUser;
    }

    /**
     * @param $userId
     * @param $projectId
     *
     * @return
     */
    public function updateOrCreate($userId, $projectId)
    {
        try {
            $inviteUser = $this->model->updateOrCreate(
                [
                    'user_id'    => $userId,
                    'project_id' => $projectId,
                ],
                [
                    'user_id'    => $userId,
                    'project_id' => $projectId,
                    'token'      => str_random(60),
                ]
            );

            return $inviteUser;

        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $userId
     * @param $token
     *
     * @return mixed
     */
    public function getInviteUser($userId, $token)
    {
        try {
            return $this->model->where('user_id', $userId)->where('token', $token)->first();
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $userId
     * @param $projectId
     *
     * @return bool
     */
    public function checkInviteUserIsExpired($userId, $projectId)
    {
        try {
            $inviteUser = $this->model->where('user_id', $userId)->where('project_id', $projectId)->first();
            if ($inviteUser) {
                if (Carbon::parse($inviteUser->updated_at)->addMinutes(720)->isPast()) {
                    $inviteUser->delete();
                    return false;
                }

                return true;
            } else {
                return false;
            }

        } catch (QueryException $e) {
        }
    }
}
