<?php

return [

    /*
    |--------------------------------------------------------------------------
    | HTTP Status Messages
    |--------------------------------------------------------------------------
    |
    | When a browser requests a service from a web server, an error might occur,
    | and the server might return an error code like "404 Not Found".
    | It is common to name these errors HTML error messages.
    | But these messages are something called HTTP status messages.
    | In fact, the server always returns a message for every request.
    | The most common message is 200 OK.
    | Below is a list of HTTP status messages that might be returned:
    |
    */

    'http_ok' => 'OK', // 200
    'http_created' => 'Created', // 201
    'http_accepted' => 'Accepted', // 202
    'http_no_content' => 'No Content', // 204
    'http_bad_request' => 'Bad Request', // 400
    'http_unauthorized' => 'Unauthorized', // 401
    'http_forbidden' => 'Forbidden', // 403
    'http_not_found' => 'Not Found', // 404
    'http_request_timeout' => 'Request Timeout', // 408
    'http_unprocessable_entity' => 'Unprocessable Entity', // 422
    'http_internal_server_error' => 'Internal Server Error', // 500
];
