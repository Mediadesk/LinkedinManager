<?php

namespace Mediadesk\LinkedinManager\LinkedInAPIClient;

/**
 * Class DeleteLinkedinPost
 *
 * This class provides functionality to delete a LinkedIn post.
 */
class DeleteLinkedinPost
{
    use LinkedinRequestHeaders, HttpRequestHandler;

    /**
     * The ID of the post to be deleted.
     *
     * @var string
     */
    protected $post_id;

    /**
     * Constructor.
     *
     * @param string $post_id The ID of the post to be deleted.
     */
    public function __construct(string $post_id)
    {
        $this->post_id = $post_id;
    }

    /**
     * Deletes the LinkedIn post.
     *
     * @param string $access_token The access token of a specific LinkedIn user.
     * @return mixed The response from the LinkedIn server after the deletion.
     */
    public function delete(string $access_token)
    {
        $host = config('mediadesk-linkedin.api_host');
        $full_url = $host . "/v2/ugcPosts/" . $this->post_id;
        $payload = [];

        return $this->sendRequest($full_url, $this->getAuthorizationHeader($access_token), $payload, "DELETE");
    }

}
