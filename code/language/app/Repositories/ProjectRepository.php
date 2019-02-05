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
            return $this->model->create($data);
        } catch (QueryException $e) {

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
            $project = $this->model->where('id', $id);

            $project->name = $request->get('name');
            $project->public = $request->get('public');
            $project->language = $request->get('language');

            $project->save();

            return [
              'status' => true,
              'data' => $project,
            ];
        } catch (QueryException $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function getProjectLanguages($id)
    {
        try {
            return $this->model->where('id', $id)->languages()->get();
        } catch (QueryException $e) {

        }
    }
}
