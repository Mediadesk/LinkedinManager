<?php

namespace Mediadesk\LinkedinManager\Services;

class LinkedinSpecificContent
{

    /**
    * @var array Attach Linkedin Uploaded Medias
    */
    protected $media = [];

    /**
    * @var array Post Message Payload
    */
    protected array $shareCommentary = [];

    /**
     * @var string Post Category Type
     * 
     */
    protected $shareMediaCategory = "NONE";


    /**
     * 
     * @param string $content_text Post Message or text
     * 
     * @return self
     * 
     */

    public function __construct($content_text)
    {
        $this->setContent($content_text);
    }


    /**
     * 
     * @param LinkedinMedia Linkedin Media Object
     * 
     * @return self
     * 
     */

    public function setImage(LinkedinMedia $media): self
    {
        $this->shareMediaCategory = "IMAGE";

        $this->media[] = $media->getPayload();

        return $this;
    }


    /**
     * 
     * We will use this media for the post content
     * 
     * @return array Linkedin Medias
     * 
     */

    public function getMedia(): array
    {
        return $this->media;
    }


     /**
     * 
     * @param string $content_text Set Post Message
     * 
     * @return self
     * 
     */
    public function setContent($content_text): self
    {
        $this->shareCommentary = [  "text" => $content_text ];

        return $this;
    }


    /**
     * 
     * @return array Payload of this class object
     * 
     */
    public function getPayload(): array
    {
        return get_object_vars($this);
    }

}
