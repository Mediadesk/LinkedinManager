<?php

namespace Mediadesk\LinkedinManager\LinkedInAPIClient;

use Exception;

class LinkedinProfile
{
    use  LinkedinRequestHeaders, HttpRequestHandler;

     /**
     * @var string Base Url to access user info from linkedin endpoint
     */
    protected string $api_host = 'https://api.linkedin.com/v2/userinfo';


     /**
     * @var string Linkedin User Access Token
     */
    protected $access_token;


    /**
     * @var string Linkedin Account Holder Name
     */
    protected $name;
    

    /**
     * @var string Linkedin Unique member id
     */
    protected $member_id;


    /**
     * @var string Linkedin profile image/avatar
     */
    protected $profile_image;


    /**
     * @var bool Determine whether the object contains profile data
     */
    protected $is_profile_exists = false;

    public function __construct($access_token)
    {
        $this->access_token = $access_token;
        $this->loadProfile();
    }

    /**
     * Get the url of a Profile Image/Avatar
     * 
     * @return string|null;
     */
    public function getProfileImage() : string|null
    {
        return $this->profile_image;
    }

    /**
     * Set the url of profile_image
     *
     * @return  self
     */
    public function setProfileImage(string|null $profile_image): self
    {
        $this->profile_image = $profile_image;

        return $this;
    }

    /**
     * Get the value of member_id
     */
    public function getMemberId() :string
    {
        return $this->member_id;
    }

    /**
     * Set the value of member_id
     *
     * @return  self
     */
    public function setMemberId($member_id) : self
    {
        $this->member_id = $member_id;

        return $this;
    }


     /**
     * Initialize the request to retrieve profile data
     * @return void
     * @throws Exception
     */
    public function loadProfile() : void
    {
        $response  = $this->sendRequest($this->api_host, $this->getAuthorizationHeader($this->access_token), [], "GET");

        if(isset($response->name))
        {
            $this->is_profile_exists = true;
            $this->setName($response->name)
                 ->setMemberId($response->sub)
                 ->setProfileImage($response->picture ?? null);
                 return;
        }

        throw new Exception('Invalid access token', 401);
    }

    /**
     * Get the value of name
     */
    public function getName() :string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName(string $name) :self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the boolen value of is_profile_exists
     */
    public function hasProfile(): bool
    {
        return $this->is_profile_exists;
    }

}
