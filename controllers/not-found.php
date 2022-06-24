<?php

include __DIR__ . "/../library/response.php";

class NotFoundController
{
    public static function all()
    {
        Response::json(404, [], ["success" => false, "error" => "Not found"]);
    }
}
