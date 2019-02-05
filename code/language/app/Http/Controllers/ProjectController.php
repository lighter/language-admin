<?php

namespace App\Http\Controllers;

use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @property ProjectRepository projectRepository
 */
class ProjectController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * ProjectController constructor.
     *
     * @param ProjectRepository $projectRepository
     * @param UserRepository    $userRepository
     */
    public function __construct(
        ProjectRepository $projectRepository,
        UserRepository $userRepository
    ) {
        $this->projectRepository = $projectRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newProject = $this->projectRepository->createProject([
            'name'     => $request->get('name'),
            'public'   => $request->get('public'),
            'language' => json_encode($request->get('language', [])),
        ]);

        $newProject->users()->attach($request->user());

        return response()->json(['data' => $newProject], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = \Auth::user();
        $userProject = $this->userRepository->getUserProject($user->id, $id);
        return response()->json(['data' => $userProject], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = \Auth::user();
        $userProject = $this->userRepository->getUserProject($user->id, $id);
        return response()->json(['data' => $userProject], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->merge(['language' => json_encode($request->get('language', []))]);
        $updateResult = $this->projectRepository->updateProject($request, $id);

        return response()->json(['data' => $updateResult], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param $projectId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProjectLanguages($projectId)
    {
        $user = \Auth::user();
        $userProjectLanguages = $this->userRepository->getUserProjectLanguage($user->id, $projectId);
        $project = $this->userRepository->getUserProject($user->id, $projectId);

        return response()->json([
            'data'    => $userProjectLanguages,
            'project' => $project,
        ], Response::HTTP_OK);
    }
}
