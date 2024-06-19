<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use GuzzleHttp\Client;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function callCheckBlackList($firstnme, $lastname, $email){
        $client = new Client();
        $response = $client->post('http://44.210.144.170/check-blacklist', [
            'json' => [
                "first_name" => $firstnme ,
                "last_name" => $lastname,
                "email" =>  $email
            ]
        ]);
        $body = $response->getBody();
        return json_decode($body, true)['is_in_blacklist'];
    }
}
