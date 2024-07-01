<?php

namespace App\Helpers;

class HttpResponse
{
    /**
     * @param $data
     * @param $status
     * @return \stdClass
     */
    public static function response($data, $status): \stdClass
    {
        $response = new \stdClass();
        $response->data = $data;
        $response->status = $status;
        return $response;
    }
}