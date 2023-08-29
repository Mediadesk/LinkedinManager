<?php

namespace Mediadesk\LinkedinManager;

use Mediadesk\LinkedinManager\Services\LinkedinAuthorization;
use Mediadesk\LinkedinManager\Services\LinkedinMediaRegister;
use Mediadesk\LinkedinManager\Services\LinkedinPost;
use Mediadesk\LinkedinManager\Services\LinkedinProfile;
use Mediadesk\LinkedinManager\Services\LinkedinSpecificContent;
use Mediadesk\LinkedinManager\Services\LinkedinUploadImage;

class LinkedinAgent
{

    /**
     * Return the url to sign in with linkedin.
     * 
     * @param  string  $client_id Client ID of a Linkedin developer account
     * @param  string  $redirect_uri Pass the redirect uri of your application to receive code, Typically its considered as a callback for your linkedin callback
     * @return string
     */
    public function getLoginUrl(string $client_id, string $redirect_uri): string
    {
       return (new LinkedinAuthorization($client_id, $redirect_uri))->getLoginLink();
    }


    /**
     * Returns the LinkedinProfile Object
     *
     * @param  string  $access_token An accesstoken of authenticated user
     * @return LinkedinProfile
     */
    public function getProfile(string $access_token): LinkedinProfile
    {
       return (new LinkedinProfile($access_token));
    }


    /**
     * Returns the Created Post Response from Linkedin Server
     *
     * @param  string $text A Text Message
     * @param  string $member_id A member ID of a specific linkedin Profile
     * @param  string $access_token Accesstoken of a specific user of linkedin 
     * 
     * 
     * @return mixed
     */
    public function createTextPost(string $text, mixed $member_id, string $access_token)
    {
       $specific_post = (new LinkedinSpecificContent($text));

       return (new LinkedinPost($member_id, $specific_post))->create($access_token);
    }


    /**
     * Returns the Media Register Object for building image upload request
     *
     * @param  string $member_id A member ID of a specific linkedin Profile
     * @param  string $access_token Accesstoken of a specific user of linkedin 
     * 
     * 
     * @return LinkedinMediaRegister
     */
    public function createMediaRegister(mixed $member_id, string $access_token): LinkedinMediaRegister
    {
         return (new LinkedinMediaRegister($member_id))
                           ->register($access_token);
    }


    /**
     * Returns the Media ID for the uploaded media
     *
     * @param  LinkedinMediaRegister $media_register A Media Register Object
     * @param  string $file Absolute path of a media
     * @param  string $access_token Accesstoken of a specific user of linkedin 
     * 
     * 
     * @return mixed
     */
    public function uploadMedia(LinkedinMediaRegister $media_register, string $file, string $access_token): mixed
    {
         return $this->mediaUploadAdapter($media_register->getAssetUrl(), $file)
                     ->create($access_token, $media_register->getId());
    }


    /**
     * Uploads the linkedin media file 
     *
     * @param  string $asset_url LinkedinMediaRegister asset url
     * @param  string $file_path Absolute media path 
     * 
     * 
     * @return LinkedinUploadImage
     * 
     */
     public function mediaUploadAdapter(string $asset_url, string $file_path): LinkedinUploadImage
     {
         return (new LinkedinUploadImage($asset_url, $file_path));
     }

     
}

