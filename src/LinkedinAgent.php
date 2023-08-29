<?php

namespace Mediadesk\LinkedinManager;

use Mediadesk\LinkedinManager\Services\DeleteLinkedinPost;
use Mediadesk\LinkedinManager\Services\LinkedinAccessToken;
use Mediadesk\LinkedinManager\Services\LinkedinAuthorization;
use Mediadesk\LinkedinManager\Services\LinkedinMedia;
use Mediadesk\LinkedinManager\Services\LinkedinMediaRegister;
use Mediadesk\LinkedinManager\Services\LinkedinPost;
use Mediadesk\LinkedinManager\Services\LinkedinProfile;
use Mediadesk\LinkedinManager\Services\LinkedinSpecificContent;
use Mediadesk\LinkedinManager\Services\LinkedinUploadImage;
use Mediadesk\LinkedinManager\Services\ViewLinkedinPost;

class LinkedinAgent
{

    /**
    * Returns the URL for signing in with LinkedIn.
    *
    * @param string $client_id The Client ID of a LinkedIn developer account.
    * @param string $redirect_uri The Redirect URI of your application where the authorization code will be sent, typically used as a callback.
    *
    * @return string The URL for signing in with LinkedIn.
    */
    public function getLoginUrl(string $client_id, string $redirect_uri): string
    {
       return (new LinkedinAuthorization($client_id, $redirect_uri))->getLoginLink();
    }


   /**
    * Retrieves the LinkedinProfile Object.
    *
    * @param string $access_token The access token of a specific LinkedIn user.
    *
    * @return LinkedinProfile The LinkedInProfile Object representing the user's LinkedIn profile.
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
     * @param  string $access_token The access token of a particular LinkedIn user.
     * 
     * 
     * @return mixed
     */
    public function createPost(string $text, mixed $member_id, string $access_token)
    {
       $specific_post = (new LinkedinSpecificContent($text));

       return (new LinkedinPost($member_id, $specific_post))->create($access_token);
    }


    /**
    * Retrieves a created post along with media responses from the LinkedIn Server.
    *
    * @param string $text The text message content.
    * @param array<int, LinkedinMedia> $medias The uploaded LinkedIn media items.
    * @param string $member_id The member ID associated with a specific LinkedIn Profile.
    * @param string $access_token The access token of a particular LinkedIn user.
    *
    * @return mixed The response containing the created post and associated media from the server.
    */
    public function createPostWithMedia(string $text, array $medias = [], mixed $member_id, string $access_token)
    {
       $specific_post = (new LinkedinSpecificContent($text));

       foreach($medias as $media)
       {
         $specific_post->setImage($media);
       }

       return (new LinkedinPost($member_id, $specific_post))->create($access_token);
    }


    /**
    * Retrieves the Media Register Object for constructing an image upload request.
    *
    * @param string $member_id The member ID of a specific LinkedIn Profile.
    * @param string $access_token The access token of a particular LinkedIn user.
    *
    * @return LinkedinMediaRegister The Media Register Object used for building upload requests.
    */
    public function createMediaRegister(mixed $member_id, string $access_token): LinkedinMediaRegister
    {
         return (new LinkedinMediaRegister($member_id))
                           ->register($access_token);
    }


   /**
    * Retrieves the Media ID for the uploaded media.
    *
    * @param LinkedinMediaRegister $media_register A Media Register Object.
    * @param string $file Absolute path of the media.
    * @param string $access_token The access token of a specific LinkedIn user.
    *
    * @return mixed The response containing the Media ID for the uploaded media.
    */
    public function uploadMedia(LinkedinMediaRegister $media_register, string $file, string $access_token): mixed
    {
         return $this->mediaUploadAdapter($media_register->getAssetUrl(), $file)
                     ->create($access_token, $media_register->getId());
    }


    /**
    * Uploads a LinkedIn media file.
    *
    * @param string $asset_url The asset URL from LinkedinMediaRegister.
    * @param string $file_path The absolute path of the media file.
    *
    * @return LinkedinUploadImage The response containing information about the uploaded image on LinkedIn.
    */
     public function mediaUploadAdapter(string $asset_url, string $file_path): LinkedinUploadImage
     {
         return (new LinkedinUploadImage($asset_url, $file_path));
     }


   /**
    * Creates an image gallery for uploading images.
    *
    * @param string $title The title of the media.
    * @param string $description The description of the media.
    *
    * @return LinkedinMedia The created LinkedIn media object.
    */
    public function LinkedinMedia(string $title, string $description, mixed $media_id): LinkedinMedia
    {
         return (new LinkedinMedia($title, $description, $media_id));
    }


 
    /**
    * View details of a specific post.
    *
    * @param string $post_id The ID of the post to view.
    * @param string $access_token The access token of a specific LinkedIn user.
    */
    public function viewPost(string $post_id, string $access_token): mixed
    {
         return (new ViewLinkedinPost($post_id))->view($access_token);
    }


    /**
    * Delete a LinkedIn post.
    *
    * @param string $post_id The ID of the post to be deleted.
    * @param string $access_token The access token of a specific LinkedIn user.
    * @return mixed The response from the LinkedIn server after the deletion.
    */
   public function deletePost(string $post_id, string $access_token): mixed
   {
      return (new DeleteLinkedinPost($post_id))->delete($access_token);
   }



    /**
     * Genrate Access token using a code returned from callback link.
     *
     * @param string $code An unique code received from the callback
     * 
     * @param string $state A State received from callback or redirect
     * 
     * @return mixed
    */
    public function getAccessToken(string $code, string $state): string|null
    {
       return (new LinkedinAccessToken(config('mediadesk-linkedin.client_id'), config('mediadesk-linkedin.secret'), $code, config('mediadesk-linkedin.callback'), $state))
                     ->getAccessToken();
    }
     
}

