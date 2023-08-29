<?php

namespace Mediadesk\LinkedinManager\Services;

trait LinkedinRequestHeaders
{
    public function getAuthorizationHeader($access_token)
    {
        return [
            "Authorization" => 'Bearer '. $access_token,
            'Accept'        => 'application/json', 
            'Content-Type'  => 'application/json'
        ];
    }
}
