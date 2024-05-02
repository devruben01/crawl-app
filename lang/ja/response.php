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
    'http_created' => '作成済み', // 201
    'http_accepted' => '受け入れ済み', // 202
    'http_no_content' => 'コンテンツなし', // 204
    'http_bad_request' => '不正な要求', // 400
    'http_unauthorized' => '無許可', // 401
    'http_forbidden' => '禁止', // 403
    'http_not_found' => '見つかりません', // 404
    'http_request_timeout' => '要求のタイムアウト', // 408
    'http_unprocessable_entity' => '処理不可能なエンティティ', // 422
    'http_internal_server_error' => '内部サーバー エラー', // 500
];
