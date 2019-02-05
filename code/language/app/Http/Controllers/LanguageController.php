<?php

namespace App\Http\Controllers;

use App\Repositories\LanguageRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class LanguageController
 *
 * @package App\Http\Controllers
 */
class LanguageController extends Controller
{
    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    /**
     * LanguageController constructor.
     *
     * @param LanguageRepository $languageRepository
     */
    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $lang_key = $request->get('lang_key', []);
        $lang_key = is_array($lang_key) ? json_encode($lang_key) : $lang_key;

        $newLanguage = $this->languageRepository->createLanguage([
            'project_id' => $request->get('pid'),
            'user_id'    => \Auth::user()->id,
            'lang_key'   => $lang_key,
            'lang'       => $request->get('lang'),
        ]);

        return response()->json(['data' => $newLanguage], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $lang_key = $request->get('lang_key', []);
        $lang_key = is_array($lang_key) ? json_encode($lang_key) : $lang_key;

        $updateResult = $this->languageRepository->updateLanguage([
            'lang'     => $request->get('lang'),
            'lang_key' => $lang_key,
        ], $id);

        return response()->json(['data' => $updateResult], Response::HTTP_OK);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $deleteResult = $this->languageRepository->destroyLanguage(\Auth::user()->id, $id);

        return response()->json(['data' => $deleteResult], Response::HTTP_OK);
    }
}
