<?php

namespace Mediadesk\LinkedinManager\LinkedInAPIClient;

trait LinkedinRequestHeaders
{
    public function getAuthorizationHeader(string $access_token): array
    {
        return [
            "Authorization" => 'Bearer '. $access_token,
            'Accept'        => 'application/json', 
            'Content-Type'  => 'application/json'
        ];
    }


    public function authorizationHeader(string $access_token): array
    {
        return [
            "Authorization" => 'Bearer '. $access_token
        ];
    }
}
