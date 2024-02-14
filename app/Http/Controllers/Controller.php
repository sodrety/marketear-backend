<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Nette\Utils\Strings;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function hitApi($uri, $endpoint, $header = [], $method = 'post', $payload = [])
    {
        $result = [
            'status' => false,
            'data'   => null,
            'error'  => null
        ];
        $guzzle = new Client(['base_uri' => $uri]);
        if ($method == 'post') {
            $param = [
                'json' => $payload
            ];
        } else {
            $param = [
                'query' => $payload
            ];
        }

        if(count($header)) {
            $param['headers'] = $header;
        }
        try {
            $response = $guzzle->request($method, $endpoint, $param);

            $result['data'] = json_decode($response->getBody()->getContents());
            $result['status'] = true;
        } catch(Exception $e) {
            Log::debug(json_encode($e));
            $result['error'] = json_encode($e);
        }

        return $result;
    }
}
