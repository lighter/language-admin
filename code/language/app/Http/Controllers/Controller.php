<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getPaginationData($pageData)
    {
        $pageData = $pageData->toArray();
        $data = $pageData['data'] ?? [];
        $pagination = [
            'current_page'     => $pageData['current_page'],
            'last_page'        => $pageData['last_page'],
            'per_page'         => $pageData['per_page'],
            'total_data_count' => $pageData['total'],
            'total_page'       => round($pageData['total'] / $pageData['per_page']),
        ];

        return [$data, $pagination];
    }
}
