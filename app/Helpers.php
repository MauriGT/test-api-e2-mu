<?php

namespace App;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class Helpers
{
    public function get($url){

        return Http::retry(3, 100, function ($exception) {
            return $exception instanceof ConnectionException;
        })->get($url);

    }
}
