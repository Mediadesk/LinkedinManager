<?php

namespace Mediadesk\LinkedinManager\Services;


class LinkedinAccessToken
{

    use HttpRequestHandler;

    /**
     * @var string The Base Uri of Linkedin Access Token Endpoint
     */
    protected $link_uri = "https://www.linkedin.com/oauth/v2/accessToken?";


    /**
     * @var string The accesstoken grant types
     */
    protected $grant_type = "authorization_code", $client_secret, $redirect_uri;

    /**
     * @var string The Client ID of a Linkedin developer account
     */
    protected $client_id;

    /**
     * @var string A code received from callback or redirect
     */
    protected $code;


    /**
     * Returns the AccessToken for Managing accounts on behalf of a user
     * 
     * @param string $client_id The Client ID of a Linkedin developer account
     * @param string $client_secret  The Client Secret of a Linkedin developer account
     * @param string $code   A code received from callback or redirect
     * @param string $redirect_uri  A redirect Uri of your application
     *
     * @return self
     */

    public function __construct($client_id, $client_secret, $code, $redirect_uri)
    {
        $this->client_id     = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_uri  = $redirect_uri;
        $this->code          = $code;
    }


    /**
     * Returns the url to obtain the access token from Linkedin 
     *
     * @return string
     */

    protected function generateUrl()
    {
        return $this->link_uri . http_build_query($this->generateParam());
    }



     /**
     * Returns an array as a payload for linkedin access token request
     *
     * @return array
     */
    protected  function generateParam() : array
    {
        return [
            "grant_type"        => $this->grant_type,
            "code"              => $this->code,
            "client_id"         => $this->client_id,
            "client_secret"     => $this->client_secret,
            "redirect_uri"      => $this->redirect_uri
        ];
    }


    /**
     * Validates the existance of a token
     *
     * @return bool
     */

    protected  function validate(mixed $response): bool
    {
        if(!isset($response->access_token))
        {
            return false;
        }

        return true;
    }


    /**
     * Returns the accesstoken for a account
     *
     * @return string|null
     */

    public function getAccessToken(): string|null
    {
        $response  = $this->sendRequest($this->generateUrl(), [], [], "POST");

        if($this->validate($response))
        {
            return $response->access_token;
        }

        return null;
    }

}
