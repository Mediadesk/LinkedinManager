<?php

namespace Mediadesk\LinkedinManager\Services;


use Illuminate\Support\Facades\Http;

trait HttpRequestHandler
{

    /**
     * A Default headers used to pass linkedin endpoints
     * @var string
     */
    protected array $default_header = ['Accept' => 'application/json', 'Content-Type' => 'application/json'];


     /**
     * A method for sending requesting from another server used for any linkedin
     * 
     * @param string $url Full Url
     * @param array $headers Full Headers
     * @param array $body Post Params
     * @param string $method Request method
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


}
