<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Slack Token
    |--------------------------------------------------------------------------
    |
    | Here you may specify your Slack Token. This will be used to authenticate with the
    | Slack API - To create a new token you have to create a slack app and then create
    | a token with the necessary scopes in your Slack Workspace dashboard.
    */

    'token' => env('SLACK_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | The timeout may be used to specify the maximum number of seconds to wait
    | for a response. By default, the client will time out after 30 seconds.
    */

    'request_timeout' => env('SLACK_REQUEST_TIMEOUT', 30),
];
