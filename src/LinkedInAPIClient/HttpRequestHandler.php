<?php

namespace Mediadesk\LinkedinManager\LinkedInAPIClient;


use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

/**
 * This class serves the purpose of sending server requests to - 
 * third-party servers for all LinkedIn API endpoints.
 * 
 * @var self
 */

trait HttpRequestHandler
{
     /**
     * Sends an HTTP request to the LinkedIn server.
     *
     * @param  string $full_url The full URL to which the request is sent.
     * @param  array $header_info The headers to include in the request.
     * @param  mixed $body The body of the request.
     * @param  string $method The HTTP method of the request (GET, POST, PUT, DELETE, etc.).
     * 
     * @return mixed The decoded JSON response from the server.
     */
    public function sendRequest($full_url, $header_info, $body, $method): mixed
    {
        $form_request = [
            'headers' => $header_info,
        ];

        if($method == 'POST' || $method == 'PUT')
        {
            $form_request = array_merge($form_request, [
                'body'  => json_encode($body)
            ] );
        }

        $response =  Http::send($method, $full_url, $form_request);

        return json_decode($response);
    }



    /**
     * Upload files over PUT method
     * 
     * @param  string  $url Full Url
     * @param  string  $file_path Absolute File Path
     * @param  array   $header Request headers
     * 
     * @return mixed
     */
    public function UploadFileRequest(string $url, string $file_path, array $header): mixed
    {
        $file_contents     = file_get_contents($file_path);
        $json_data         = json_decode($file_contents);
        $encoded_json_data = json_encode($json_data, JSON_UNESCAPED_UNICODE);

        $response          = Http::withHeaders($header)
                               ->put($url, $encoded_json_data);

        return $response->status();
    }

    /**
     * Upload files over PUT method using  guzzle
     * 
     * @param  string  $url Full Url
     * @param  string  $file_path Absolute File Path
     * @param  array   $header Request headers
     * 
     * @return mixed
     */
    public function uploadFileWithGuzzle(string $url, string $file_path, array $header)
    {
        $client = new Client();
        $file   = file_get_contents($file_path);
        $request = new Request(
            'PUT',
            $url,
            $header,
            $file
        );

        $response = $client->send($request);

        return $response->getStatusCode();
    }


}
