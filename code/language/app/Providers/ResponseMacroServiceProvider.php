<?php

namespace App\Providers;

use Illuminate\Http\Response;
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
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
