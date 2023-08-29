# Linkedin Manager (Beta)
LinkedIn Integration Package for Laravel (Unofficial Package)

This package provides integration with the LinkedIn API for Laravel applications. It allows you to perform various LinkedIn-related tasks such as authenticating users, retrieving profiles, creating and deleting posts, and more.

**Please Note:** This package is currently in active development and should be used with caution. While we are working hard to ensure stability and functionality, there might be frequent updates and changes that could impact your usage.


## Important: Business Developer Account Requirement

Creating and managing accounts on behalf of another user requires a Business Developer account on LinkedIn. Make sure you have the necessary permissions and access before using this feature.




## Get Started

> **Requires [PHP 8.1+](https://php.net/releases/)**

To get started with the LinkedinManager package, follow these steps:

Install the package using Composer:
   ```sh
   composer require mediadesk/linkedin-manager:dev-main
   ```

## Publish Config File

To customize the configuration settings of the Mediadesk Linkedin Manager package, you can publish the config file using the following Artisan command:

```sh
php artisan vendor:publish --tag=mediadesk-linkedin
```


## Configuration

Ensure the following environment variables are set in your .env file:

 ```sh
LINKEDIN_CLIENT_ID=
LINKEDIN_CLIENT_SECRET=
LINKEDIN_CALLBACK=
 ```


## Usage

## Creating Login URL

To create a login URL for LinkedIn authentication, make sure to add the callback URI to your LinkedIn Developer application. Then, use the following code:

 ```sh
$linkedin_agent = new LinkedinAgent();
$loginUrl       = $linkedin_agent->getLoginUrl();
```

## Generating Access Token

Generate an access token from the callback URL. You will receive the code and state in the URL parameters. Use the following code:


```sh
$linkedin_agent = new LinkedinAgent();
$access_token   = $linkedin_agent->getAccessToken($code, $state);
```

## Managing User Profiles

Retrieve user profile information, including member ID, name, and profile image, using the following code:

```sh
$linkedin_profile = $linkedin_agent->getProfile($access_token);
$member_id        = $linkedin_profile->getMemberId();
$name             = $linkedin_profile->getName();
$profile_image    = $linkedin_profile->getProfileImage();
```


## Creating Text Posts

Create a text-only post on LinkedIn using the following code:

```sh
$linkedin_agent->createTextPost('Hello world!', $member_id, $access_token);
```


## Creating Posts with Media

To create a post with media, you'll need to register the media and then upload it. Here's how:

```sh
$image_register   = (new LinkedinMediaRegister($member_id))->register($access_token);
$media_id         = $linkedin_agent->uploadMedia($image_register, '/path/to/media/file', $access_token);
$LinkedinMedia[]  = $linkedin_agent->LinkedinMedia('Cat', 'Working on iOS', $media_id);

$linkedin_agent->createPostWithMedia('Wow, a beautiful cat here!', $LinkedinMedia, $member_id, $access_token);
```

## Deleting a Post

Delete a post using the following code:

```sh
$linkedin_agent->deletePost($post_id, $access_token);
```


## Contributing

Contributions are welcome! If you encounter any issues or have suggestions, please open an issue.


## License

Linkedin Manager is an open-sourced software licensed under the **[MIT license](https://opensource.org/licenses/MIT)**.
