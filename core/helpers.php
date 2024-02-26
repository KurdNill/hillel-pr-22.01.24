<?php
namespace Core;
function json_response(int $code = 200, array $data = []): string
{
    header_remove();
    http_response_code($code);
    header("Cache-Control: no-transform,public,max-age:300,s-maxage=900");
    header("Content-Type: application/json");

    $statuses = [
        200 => '200 OK',
        400 => '400 Bad Request',
        403 => '403 Forbidden',
        405 => '405 Method Not Allowed',
        422 => '422 Unprocessable Entity',
        500 => '500 Internal Server Error'
    ];

    header("Status: " . $statuses[$code]);

    return json_encode([
        'code' => $code,
        'status' => $statuses[$code],
        ...$data
    ]);
}

function db(): \PDO
{
    return DB::connect();
}

function requestBody(): array
{
    $data = [];
    $requestBody = file_get_contents('php://input');

    //isset()
    if (!empty($requestBody)) {
        $data = json_decode($requestBody, true);
    }
    return $data;
}

//function getToken()
//{
//    $headers = apache_request_headers();
//
//    if (!isset($headers['Authorization'])) {
//        throw new \Exception('');
//    }
//
//    $token = str_replace('Bearer', '', $headers['Authorization']);
//
//    if (!Token::validateExpiration()) {
//
//    }
//
//    return $token;
//}

//function authId()
//{
//    $token = Token::getPayload(getAuthToken());
//}