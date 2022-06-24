<?php

include __DIR__ . "/../library/request.php";
include __DIR__ . "/../library/response.php";
include __DIR__ . "/../models/users.php";

class LoginController
{
    public static function post()
    {
        try {
            $json = Request::json();
            $user = UserModel::getOneByEmail($json->email);

            if (!$user) {
                Response::json(400, [], ["success" => false, "error" => "Bad request"]);
                return;
            }

            if (!password_verify($json->password, $user["password"])) {
                Response::json(400, [], ["success" => false, "error" => "Bad request"]);
                return;
            }

            $token = bin2hex(random_bytes(16));

            UserModel::updateOneById($user["id"], ["token" => $token]);
            Response::json(200, [], ["success" => "aucun problèmes (jeton créé en BDD et renvoyé)", "token" => $token]);
        } catch (PDOException $exception) {
            Response::json(500, [], ["success" => false, "error" => $exception->getMessage()]);
        }
    }

    public static function delete()
    {
        try {
            $json = Request::json();
            $headers = Request::headers();

            if (!isset($headers["token"])) {
                Response::json(403, [], ["success" => false, "error" => "Forbidden"]);
                return;
            }

            $user = UserModel::getOneByToken($headers["token"]);

            if (!$user) {
                Response::json(404, [], ["success" => false, "error" => "Not found"]);
                return;
            }

            UserModel::updateOneById($user["id"], [
                "token" => NULL
            ]);

            Response::json(200, [], ["success" => " aucun problèmes (jeton supprimé en BDD)"]);
        } catch (PDOException $exception) {
            Response::json(500, [], ["success" => false, "error" => $exception->getMessage()]);
        }
    }
}
