<?php

namespace Mediadesk\LinkedinManager;

use Mediadesk\LinkedinManager\Services\LinkedinAuthorization;
use Mediadesk\LinkedinManager\Services\LinkedinPost;
use Mediadesk\LinkedinManager\Services\LinkedinProfile;
use Mediadesk\LinkedinManager\Services\LinkedinSpecificContent;

class LinkedinAgent
{

    /**
     * Return the url to sign in with linkedin.
     * 
     * @param  string  $client_id Client ID of a Linkedin developer account
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


    /**
     * Returns the Created Post Response from Linkedin Server
     *
     * @param  string $text A Text Message
     * @param  string $member_id A member ID of a specific linkedin Profile
     * @param  string $access_token Accesstoken of a specific user of linkedin 
     * 
     * 
     * @return mixed
     */
    public function createTextPost(string $text, mixed $member_id, string $access_token)
    {
       $specific_post = (new LinkedinSpecificContent($text));

       return (new LinkedinPost($member_id, $specific_post))->create($access_token);
    }

}

