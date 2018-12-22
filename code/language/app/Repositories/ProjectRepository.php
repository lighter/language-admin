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
    public function createProject(array $data): Project
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $e) {

        }
    }

    /**
     * @param $id
     *
     * @return Project
     */
    public function findProject($id): Project
    {
        try {
            return $this->model->find($id);
        } catch (QueryException $e) {

        }
    }

    /**
     * @param $request
     * @param $id
     *
     * @return Project
     */
    public function updateProject($request, $id): Project
    {
        try {
            $project = $this->model->find($id);

            $project->name = $request->get('name');

            $project->save();

            return $project;
        } catch (QueryException $e) {

        }
    }
}
