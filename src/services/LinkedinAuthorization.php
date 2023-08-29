<?php

namespace Mediadesk\LinkedinManager\Services;

use Illuminate\Support\Str;

class LinkedinAuthorization
{

     /**
     * @var string The base Url for authorization
     */
    protected $link_uri = "https://www.linkedin.com/oauth/v2/authorization?";


     /**
     * @var string Obtain login credential type
     */
    protected $response_type = "code";
    

    /**
     * @var string The Redirect link of the application
     */
    protected $redirect_uri; 
    

     /**
     * @var string The Random Alphanumeric Character used for veryfying redirect Uri.
     */
    protected $state;

     /**
     * @var string The Client ID of a developer account
     */
    protected $client_id;


    /**
     * Returns the authorization object for accesssing linkedin login
     * 
     * @param string $linkedin_client_id The Client ID of a developer account
     * @param string $redirect_uri  The Redirect link of the application
     *
     * @return self
     */
    public function __construct(string $linkedin_client_id, string $redirect_uri)
    {
        $this->client_id     = $linkedin_client_id;
        $this->state         = Str::random(8);
        $this->redirect_uri  = $redirect_uri;
    }


     /**
     * Return the link of Linkedin login
     *
     * @return string
     */
    public function getLoginLink(): string
    {
        session()->put("linkedin_auth_state", $this->state);

        return $this->link_uri . http_build_query($this->generateParam()) . "&scope=r_liteprofile%20r_emailaddress%20w_member_social%20profile%20openid";
    }


     /**
     * Return the Payload which will contain required params to pass for linkedin
     *
     * @return array
     */
    protected  function generateParam() : array
    {
        return [
            "response_type" => $this->response_type,
            "client_id"     => $this->client_id,
            "redirect_uri"  => $this->redirect_uri,
            "state"         => $this->state
        ];
    }

}
