<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('api_response', function ($data = []) {

            if (array_key_exists('error', $data)) {
                $data['error'] = is_array($data['error']) ? $data['error'] : [$data['error']];
            }

            $response_information = [
                'status_code' => $data['code'] ?? 200,
                'status'      => $data['status'] ?? false,
                'body'        => $data['data'] ?? [],
                'error'       => $data['error'] ?? [],
            ];

            return Response::make($response_information);
        });


        Response::macro('lang_response', function (array $data = []) {

            if (array_key_exists('errors', $data)) {
                $data['errors'] = is_array($data['errors']) ? $data['errors'] : [$data['errors']];
            }

            $self_response_information = [
                'status_code' => $data['code'] ?? 200,
                'status'      => $data['status'] ?? false,
                'body'        => $data['data'] ?? [],
                'errors'      => $data['errors'] ?? [],
            ];

            return Response::make($self_response_information);
        });
    }
}
