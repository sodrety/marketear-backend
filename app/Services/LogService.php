<?php

namespace App\Services;

use App\Models\ApiLogs;

class LogService 
{
    static public function record($data)
    {
        ApiLogs::insert([
            'request' => $data['request'],
            'response' => $data['response'],
            'url' => $data['url']
        ]);
    }
}