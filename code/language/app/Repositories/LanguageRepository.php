<?php
/**
 * Created by PhpStorm.
 * User: lighter
 * Date: 2019-01-25
 * Time: 23:46
 */

namespace App\Repositories;


use App\Model\Language;
use Illuminate\Database\QueryException;

/**
 * Class LanguageRepository
 *
 * @package App\Repositories
 */
class LanguageRepository
{
    /**
     * LanguageRepository constructor.
     *
     * @param Language $language
     */
    public function __construct(Language $language)
    {
        $this->model = $language;
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function createLanguage(array $data)
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $e) {

        }
    }

    /**
     * @param $request
     * @param $id
     *
     * @return array
     */
    public function updateLanguage($data, $id)
    {
        try {
            $language = $this->model->find($id);
            $language->lang = $data['lang'];
            $language->lang_key = $data['lang_key'];

            $language->save();

            return [
                'status' => true,
                'data'   => $language,
            ];

        } catch (QueryException $e) {
            return [
                'status' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }

    /**
     * @param $user_id
     * @param $id
     *
     * @return mixed
     */
    public function destroyLanguage($user_id, $id)
    {
        try {
            return $this->model
                ->where('id', $id)
                ->where('user_id', $user_id)->delete();
        } catch (QueryException $e) {

        }
    }
}
