<?php

namespace App\Repositories;


use App\Model\Project;
use Illuminate\Database\QueryException;

/**
 * Class ProjectRepository
 *
 * @package App\Repositories
 */
class ProjectRepository
{
    /**
     * ProjectRepository constructor.
     *
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->model = $project;
    }

    /**
     * @param array $data
     *
     * @return Project
     */
    public function createProject(array $data)
    {
        try {
            $project = $this->model->create($data);

            return [
                'status' => true,
                'data'   => $project,
            ];
        } catch (QueryException $e) {
            return [
                'status' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }

    /**
     * @param $id
     *
     * @return Project
     */
    public function findProject($id)
    {
        try {
            return $this->model->where('id', $id);
        } catch (QueryException $e) {

        }
    }

    /**
     * @param $request
     * @param $id
     *
     * @return Project
     */
    public function updateProject($request, $id)
    {
        try {
            $project = $this->model->find($id);

            $project->name = $request->get('name');
            $project->public = $request->get('public');
            $project->language = $request->get('language');

            $project->save();

            return [
                'status' => true,
                'data'   => $project,
            ];
        } catch (QueryException $e) {
            return [
                'status' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getProjectLanguages($id)
    {
        try {
            return $this->model->find($id)->languages()->get();
        } catch (QueryException $e) {

        }
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getProjectOwners($id, $page, $pageSize)
    {
        try {
            return $this->model->find($id)->users()->paginate($pageSize, ['id', 'name', 'email', 'verified'], 'page',
                $page);
        } catch (QueryException $e) {

        }
    }

    /**
     * @param $projectId
     * @param $user
     *
     * @return mixed
     */
    public function assignProjectToUser($projectId, $user)
    {
        try {
            $this->model->find($projectId)->users()->attach($user, [
                'read'  => true,
                'write' => true,
                'owner' => false,
            ]);

            $inviteUser = $this->model->where('id', $projectId)->first()->users->filter(function ($users) use ($user
            ) {
                return $users->id == $user->id;
            })->first();

            if ($inviteUser) {
                return [
                    'status' => true,
                    'data'   => $inviteUser,
                ];
            }
        } catch (QueryException $e) {
            return [
                'status' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }

    /**
     * @param $projectId
     * @param $user_id
     * @param $read
     * @param $write
     *
     * @return array
     */
    public function updatePorjectOwnerSetting($projectId, $user_id, $read, $write)
    {
        try {
            $projectOwnerUser =
                $this->model->find($projectId)->users()->get()->filter(function ($users) use ($user_id) {
                    return $users->id == $user_id;
                })->first();

            if ($projectOwnerUser) {
                $result = $projectOwnerUser->projects()->updateExistingPivot(
                    $projectId, [
                    'read'  => $read,
                    'write' => $write,
                ]);

                return [
                    'status' => $result ? true : false,
                    'data'   => $projectOwnerUser->projects()->first(),
                ];
            }

        } catch (QueryException $e) {
            return [
                'status' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }

    /**
     * @param $projectId
     * @param $user
     *
     * @return array
     */
    public function checkProjectOwner($projectId, $user)
    {
        try {
            $stauts = false;

            $projectIsOWner = $this->model->find($projectId)->users()->get()->filter(function ($users) use ($user) {
                return $users->id == $user->id;
            })->first();

            if ($projectIsOWner) {
                $status = ($projectIsOWner->pivot->owner);
            }

            return ['status' => $status];

        } catch (QueryException $e) {
            return [
                'status' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }
}
