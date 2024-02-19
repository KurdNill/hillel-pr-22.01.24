<?php
namespace Core\Traits;

use Enums\HTTP;


trait HttpMethods
{
    public static function get(string $uri): static
    {
        return static::setUri($uri)->setMethod(HTTP::GET);
        //setMethod('GET')
    }

    public static function post(string $uri): static
    {
        return static::setUri($uri)->setMethod(HTTP::POST);
    }

    public static function put(string $uri): static
    {
        return static::setUri($uri)->setMethod(HTTP::PUT);
    }

    public static function delete(string $uri): static
    {
        return static::setUri($uri)->setMethod(HTTP::DELETE);
    }
}