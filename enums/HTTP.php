<?php

namespace Enums;

enum HTTP: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
}