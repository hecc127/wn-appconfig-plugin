<?php

namespace SoftWorksPy\AppConfig\Api;

class SimpleResponse
{
    public static function create($message, $code = 200)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
        ], $code);
    }
}
