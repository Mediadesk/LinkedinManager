<?php

return [

    'client_id'    => env('LINKEDIN_CLIENT_ID',''),
    'secret'       => env('LINKEDIN_CLIENT_SECRET', ''),
    'callback'     => env('LINKEDIN_CALLBACK'),
    'host'         => env('LINKEDIN_HOST', 'https://www.linkedin.com'),
    'api_host'     => env('LINKEDIN_API_HOST', 'https://api.linkedin.com'),
];
