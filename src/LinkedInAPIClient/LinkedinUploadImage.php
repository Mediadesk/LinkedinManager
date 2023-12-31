<?php

namespace Mediadesk\LinkedinManager\LinkedInAPIClient;

use Mediadesk\LinkedinManager\Requests\HttpRequestHandler;
use Mediadesk\LinkedinManager\Requests\LinkedinRequestHeaders;

/**
 * This class is intended for uploading images using a LinkedIn media register asset link.
 *
 * @return self
 */
class LinkedinUploadImage
{

    use LinkedinRequestHeaders, HttpRequestHandler;


    /**
     * LinkedIn media register asset link.
     *
     * @return string
     */
    protected $link;
    

    /**
     * Absolute file path.
     *
     * @return string
     */
    protected $file;


    /**
     * Indicates whether the file has been uploaded to the LinkedIn media register.
     *
     * @return bool
     */
    protected $is_uploaded = false;


    /**
     * Constructor for LinkedinUploadImage.
     *
     * @return self
     */
    public function __construct(string $link, string $file)
    {
        $this->link = $link;
        $this->file = $file;
    }


    /**
     * Initiates a request for LinkedIn media upload.
     *
     * @return null|string|mixed
     */
    public function create(string $access_token, string $media_id): mixed
    {
        if ($this->uploadFileWithGuzzle($this->link, $this->file, 
                $this->authorizationHeader($access_token)) === 201) 
        {
             return $media_id;
        }

        return null;
    }

}
