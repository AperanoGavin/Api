<?php

class Request
{
    public static function json()
    {
        $rawBody = file_get_contents("php://input");
        $json = json_decode($rawBody);

        return $json;
    }

    public static function headers()
    {
        return getallheaders();
    }
}
