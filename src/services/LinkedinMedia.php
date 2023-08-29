<?php

namespace Mediadesk\LinkedinManager\Services;


/**
 * This class is utilized for handling payloads required for uploading images on LinkedIn.
 * @var self
 */
class LinkedinMedia
{

    protected  $status, $description, $media, $title;


    public function __construct($title, $description, $linkedin_media_code)
    {
        $this->setStatus("READY");
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setMedia($linkedin_media_code);
    }


    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status = "READY")
    {
        $this->status = $status;

        return $this;
    }


     /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = [
            "text" => $title
        ];

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = [
            "text" => $description
        ];

        return $this;
    }

    /**
     * Get the value of media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set the value of media
     *
     * @return  self
     */
    public function setMedia($media)
    {
        $this->media = $media;
        return $this;
    }

    /**
     * Returns an array of payloads for this class.
     *
     * @return array
     */
    public function getPayload()
    {
        return get_object_vars($this);
    }
}
