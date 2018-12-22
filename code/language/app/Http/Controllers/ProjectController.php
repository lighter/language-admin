<?php

namespace App\Http\Controllers;

use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @property ProjectRepository projectRepository
 */
class ProjectController extends Controller
{
    public function __construct(ProjectRepository $projectRepository) {
        $this->projectRepository = $projectRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newProject = $this->projectRepository->createProject([
           'name' => $request->get('name'),
           'public' => $request->get('public'),
           'language' => json_encode($request->get('language', []))
        ]);

        $newProject->users()->attach($request->user());

        return response()->json(['data' => $newProject], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->projectRepository->findProject($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->projectRepository->findProject($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->projectRepository->updateProject($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
