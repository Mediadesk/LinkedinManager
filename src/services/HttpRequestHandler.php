<?php

namespace Mediadesk\LinkedinManager\Services;


use Illuminate\Support\Facades\Http;

/**
 * This class serves the purpose of sending server requests to - 
 * third-party servers for all LinkedIn API endpoints.
 * 
 * @var self
 */

trait HttpRequestHandler
{
     /**
     * A method for sending requesting from another server used for any linkedin
     * 
     * @param  string $url Full Url
     * @param  array  $headers Full Headers
     * @param  array  $body Post Params
     * @param  string $method Request method
     * @return mixed
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

}
