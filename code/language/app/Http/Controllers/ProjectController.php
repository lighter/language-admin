<?php

namespace App\Http\Controllers;

use App\Notifications\InviteUserMail;
use App\Repositories\InviteUserRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class ProjectController
 *
 * @package App\Http\Controllers
 */
class ProjectController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var InviteUserRepository
     */
    private $inviteUserRepository;
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * ProjectController constructor.
     *
     * @param ProjectRepository    $projectRepository
     * @param UserRepository       $userRepository
     * @param InviteUserRepository $inviteUserRepository
     */
    public function __construct(
        ProjectRepository $projectRepository,
        UserRepository $userRepository,
        InviteUserRepository $inviteUserRepository

    ) {
        $this->projectRepository = $projectRepository;
        $this->userRepository = $userRepository;
        $this->inviteUserRepository = $inviteUserRepository;
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

        if ($newProject['status']) {
            $newProject['data']->users()->attach($request->user(), [
                'read'  => true,
                'write' => true,
                'owner' => true,
            ]);
        }

        return response()->json(['data' => $newProject, 'status' => true], Response::HTTP_OK);
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

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProjectOwner(Request $request)
    {
        $projectId = $request->get('projectId');
        $page = $request->get('page', 1);
        $pageSize = $request->get('pageSize', 10);
        $projectOwners = $this->projectRepository->getProjectOwners($projectId, $page, $pageSize);

        [$projectOwners, $pagination] = $this->getPaginationData($projectOwners);

        return response()->json([
            'data'       => $projectOwners,
            'pagination' => $pagination,
        ], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function inviteUser(Request $request)
    {
        $status = false;

        $lang = $request->get('lang', 'en');
        $email = $request->get('email');
        $project_id = $request->get('id');
        $user = \Auth::user();

        $userProject = $this->userRepository->getUserProject($user->id, $project_id);
        $userMail = $this->userRepository->getUserByEmail($email);
        $inviteUser = $this->inviteUserRepository->updateOrCreate($userMail->id, $project_id);

        if ($userProject && $userMail && $inviteUser) {
            $user->notify(new InviteUserMail($lang, $inviteUser->token, $email));

            $status = true;
        }

        return response()->json(['status' => $status], Response::HTTP_OK);
    }

    /**
     * @param $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function activeInviteUser($token)
    {
        $status = false;

        $user = \Auth::user();
        $inviteUser = $this->inviteUserRepository->getInviteUser($user->id, $token);

        $inviteUserIsExpired =
            ($inviteUser) ? $this->inviteUserRepository->checkInviteUserIsExpired($user->id, $inviteUser->project_id) :
                null;

        if ($inviteUser && $inviteUserIsExpired) {
            $assignProjectToUser = $this->projectRepository->assignProjectToUser($inviteUser->project_id, $user);

            return $assignProjectToUser;

            if ($assignProjectToUser['status']) {
                $status = true;
            }
        }

        return response()->json(['status' => $status], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProjectOwnerSetting(Request $request)
    {
        $status = false;

        $user = \Auth::user();
        $project_id = $request->get('project_id');
        $user_id = $request->get('id');
        $read = $request->get('read');
        $write = $request->get('write');

        $checkUserIsProjectOwner = $this->projectRepository->checkProjectOwner($project_id, $user);


        if ($checkUserIsProjectOwner['status']) {
            $updateProjectOwnerSetting =
                $this->projectRepository->updatePorjectOwnerSetting($project_id, $user_id, $read, $write);

            if ($updateProjectOwnerSetting['status']) {
                $status = true;
                $data = $updateProjectOwnerSetting['data'];
            }
        }

        return response()->json(['status' => $status, 'data' => $data ?? null], Response::HTTP_OK);
    }
}
