<?php

namespace Mediadesk\LinkedinManager\Services;


/**
 * This class is used to create a Media Register Object necessary for image uploads.
 *
 * @return self
 */
class LinkedinMediaRegister
{

    use LinkedinRequestHeaders, HttpRequestHandler;


    /**
     * Request Payload to create image register.
     *
     * @var array
     */
    protected $registerUploadRequest = [];

     /**
     * Individual Image Register ID.
     *
     * @var string
     */
    protected $image_id;

    /**
     * Individual Image Asset Url.
     *
     * @var string
     */
    protected $asset_url;


    /**
     * Indicates whether this object is eligible for media registration.
     *
     * @var bool
     */
    protected $has_media = false;


    /**
     * LinkedinMediaRegister Constructor.
     * 
     * @param string $member_id Member ID of the linkedin account.
     *
     * 
     * @return self
     */
    public function __construct(string $member_id)
    {
        $this->registerUploadRequest["recipes"][] = "urn:li:digitalmediaRecipe:feedshare-image";
        $this->registerUploadRequest["owner"]   = "urn:li:person:$member_id";
        $this->registerUploadRequest["serviceRelationships"][]  =  [
            "relationshipType" => "OWNER",
            "identifier"       => "urn:li:userGeneratedContent"
        ];
    }


     /**
     * Returns an array of payloads for this class.
     *
     * @return array
     */
    public function getPayload(): array
    {
        return [
            "registerUploadRequest" => $this->registerUploadRequest
        ];
    }


     /**
     * Intiates the request to linkedin media server for image register.
     * 
     * @param string $access_token An Authorized linkedin account accesstoken
     *
     * @return self
     */
    public function register($access_token): self
    {
        $url =   config('mediadesk-linkedin.api_host') ."/v2/assets?action=registerUpload";

        $response = $this->sendRequest($url, $this->getAuthorizationHeader($access_token), $this->getPayload(), "POST");

        if(isset($response->value) && isset($response->value->asset))
        {
            $this->has_media = true;
            $this->image_id  = $response->value->asset;
            $this->asset_url = $response->value->uploadMechanism->{"com.linkedin.digitalmedia.uploading.MediaUploadHttpRequest"}->uploadUrl;
        }

        return $this;
    }


     /**
     * Returns the Media Identifier.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->image_id;
    }


     /**
     * Media register asset Url.
     *
     * @return string
     */
    public function getAssetUrl(): string
    {
        return $this->asset_url;
    }


     /**
     * Determines the media register existance.
     *
     * @return bool
     */
    public function hasMedia(): bool
    {
        return $this->has_media;
    }

}
