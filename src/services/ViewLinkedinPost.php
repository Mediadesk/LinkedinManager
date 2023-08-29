<?php

namespace Mediadesk\LinkedinManager\Services;


/**
 * This class is responsible for previewing the contents of a specific post.
 */
class ViewLinkedinPost
{

    use LinkedinRequestHeaders, HttpRequestHandler;

     /**
     * Unique Linkedin Post ID.
     *
     * @var string
     */
    protected $post_id;

     /**
     * Post Visibility.
     *
     * @var string
     */
    protected $visibility;


    /**
     * Unique Linkedin Post ID Example: urn:li:share:7102258593797742592.
     *
     * @param self
     */
    public function __construct(string $post_id)
    {
        $this->post_id   = $post_id;
    }


     /**
     * Returns the response of a particular post data.
     *
     * @param string $access_token
     * 
     * @return mixed
     */
    public function view(string $access_token): mixed
    {
        $host             = config('linkedin.api_host');
        $full_url         = $host . "/v2/ugcPosts/$this->post_id";
        $payload          = [];

        return $this->sendRequest($full_url, $this->getAuthorizationHeader($access_token), $payload, "GET");
    }

}
