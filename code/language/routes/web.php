<?php


Route::get('auth/callbackweb/{driver}', 'Auth\OAuthController@handleProviderCallback');
Route::get('/{vue?}', 'HomeController@index')->where('vue', '[\/\w\.-]*');
