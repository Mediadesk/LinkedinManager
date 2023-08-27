<?php

namespace Mediadesk\LinkedinManager;

use Mediadesk\LinkedinManager\Services\LinkedinAuthorization;
use Mediadesk\LinkedinManager\Services\LinkedinProfile;

class LinkedinAgent
{

    /**
     * Return the url to sign in with linkedin.
     *
     * @param  string  $redirect_uri Pass the redirect uri of your application to receive code, Typically its considered as a callback for your linkedin callback
     * @return string
     */
    public function getLoginUrl(string $client_id, string $redirect_uri): string
    {
       return (new LinkedinAuthorization($client_id, $redirect_uri))->getLoginLink();
    }


    /**
     * Returns the LinkedinProfile Object
     *
     * @param  string  $access_token An accesstoken of authenticated user
     * @return LinkedinProfile
     */
    public function getProfile(string $access_token): LinkedinProfile
    {
       return (new LinkedinProfile($access_token));
    }

}

