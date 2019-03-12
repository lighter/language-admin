<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');
Route::post('password/create', 'Auth\ResetPasswordController@create');
Route::get('password/find/{token}', 'Auth\ResetPasswordController@find');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
Route::post('user/verify', 'Auth\RegisterController@verifyUser');

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::post('/send', 'EmailController@send');

Route::group(['middleware' => ['auth:api']], function() {
    Route::resource('project', 'ProjectController');
    Route::get('user_project_languages/{projectId}', 'ProjectController@getProjectLanguages');

    Route::get('user_projects', 'UserController@getUserProjects');
    Route::get('users', 'UserController@getUsers');
    Route::get('users_page', 'UserController@getUsersPagination');
    Route::get('users/{id}', 'UserController@getUser');
    Route::put('users/{id}', 'UserController@updateUser');

    Route::resource('language', 'LanguageController', ['only' => ['store', 'update', 'destroy']]);
});
