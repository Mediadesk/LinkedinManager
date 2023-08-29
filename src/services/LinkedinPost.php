<?php

namespace Mediadesk\LinkedinManager\Services;


/**
 * This class is utilized to create a LinkedIn post object.
 *
 * @return self
 */
class LinkedinPost
{

    use LinkedinRequestHeaders, HttpRequestHandler;

    protected  $author, $lifecycleState, $specificContent;

    protected $visibility;

    /**
     * Constructor for a LinkedIn Post.
     * 
     * @param string $member_id The member ID of a LinkedIn profile/account.
     * @param LinkedinSpecificContent $specificContent The Post Content Object required for the LinkedIn post.
     * @param string $visibility Determines whether to publish it on the LinkedIn platform.
     *
     * @return self
     */
    public function __construct(string $member_id, LinkedinSpecificContent $specificContent, $lifecycleState = "PUBLISHED", $visibility = "PUBLIC")
    {
        $this->author = "urn:li:person:$member_id";
        $this->lifecycleState = $lifecycleState;
        $this->specificContent["com.linkedin.ugc.ShareContent"]       = $specificContent->getPayload();
        $this->visibility["com.linkedin.ugc.MemberNetworkVisibility"] = $visibility;
    }


    /**
     * Returns an array of payloads for this class.
     *
     * @return array
     */
    public function getPayload(): array
    {
        return get_object_vars($this);
    }


    /**
     * Intiates a post request to linkedin server
     * 
     * @param string $access_token Accesstoken of a linkedin authorized user
     *
     * @return mixed
     */
    public function create(string $access_token)
    {
        $host             = config('linkedin.api_host');
        $full_url         = $host . "/v2/ugcPosts";
        
        return $this->sendRequest($full_url, $this->getAuthorizationHeader($access_token), $this->getPayload(), "POST");
    }

}
