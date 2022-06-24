<?php

require __DIR__ . "/../library/response.php";
require __DIR__ . "/../models/users.php";
require __DIR__ . "/../library/request.php";

class UserController
{
    /**
     * @route GET /users
     */
    public static function get()
    {
        try {
            $headers = Request::headers();

            if (!isset($headers["token"])) {
                Response::json(401, [], ["success" => false, "error" => "pas de jeton d’authentification ou incorrect ou inexistant"]);
                return;
            }

            $user = UserModel::getOneByToken($headers["token"]);

            if (!$user) {
                Response::json(404, [], ["success" => false, "error" => "Not found"]);
                return;
            }

            if ($user["role"] !== "ADMINISTRATOR") {
                Response::json(403, [], ["success" => false, "error" => "mauvais role"]);
                return;
            }

            $statusCode = 200;

            $headers = [];

            $users = UserModel::getAll();

            $body = [
                "success" => "aucun problèmes",
                "users" => $users
            ];

            Response::json($statusCode, $headers, $body);
        } catch (PDOException $exception) {
            Response::json(500, [], ["success" => false, "error" => $exception->getMessage()]);
        }
    }

    public static function post()
    {
        try {
            $headers = Request::headers();

            if (!isset($headers["token"])) {
                Response::json(401, [], ["success" => false, "error" => " pas de jeton d’authentification ou incorrect ou inexistant"]);
                return;
            }

            $user = UserModel::getOneByToken($headers["token"]);

            if (!$user) {
                Response::json(400, [], ["success" => false, "error" => "Mauvaise donnée envoyé"]);
                return;
            }
            if ($user["role"] !== "ADMINISTRATOR") {
                Response::json(403, [], ["success" => false, "error" => "mauvais role"]);
                return;
            }

            $json = Request::json();

            $statusCode = 201;

            $headers = [];

            UserModel::createOne(
                [
                "email" => $json->email,
                "password" => password_hash($json->password, PASSWORD_BCRYPT),
                "role" => $json->role
                ]
            );

            $body = [
                "success" => "utilisateur créé"
            ];

            Response::json($statusCode, $headers, $body);
        } catch (PDOException $exception) {
            Response::json(500, [], ["success" => "mauvaises données envoyées", "error" => $exception->getMessage()]);
        }
    }

    public static function patch()
    {
        try {
            $headers = Request::headers();
            
            if (!isset($headers["token"])) {
                Response::json(401, [], ["success" => false, "error" => "pas de jeton d’authentification ou incorrect ou inexistant"]);
                return;
            }

            $user = UserModel::getOneByToken($headers["token"]);

            if (!$user) {
                Response::json(400, [], ["success" => false, "error" => "Mauvaise donnée envoyé"]);
                return;
            }
            if ($user["role"] !== "ADMINISTRATOR") {
                Response::json(403, [], ["success" => false, "error" => "mauvais rôle"]);
                return;
            }

            $json = Request::json();

            $statusCode = 200;

            $headers = [];

            $todo_id = $json->id;
            $json_array = (array) $json;

            UserModel::updateOneById($todo_id, $json_array);

            $body = [
                "success" => "aucun problème"
            ];

            Response::json($statusCode, $headers, $body);
        } catch (PDOException $exception) {
            Response::json(500, [], ["success" => false, "error" => $exception->getMessage()]);
        }
    }

    public static function delete()
    {
        try {

            $headers = Request::headers();
            
            if (!isset($headers["token"])) {
                Response::json(401, [], ["success" => false, "error" => "pas de jeton d’authentification ou incorrect ou inexistant"]);
                return;
            }

            $user = UserModel::getOneByToken($headers["token"]);

            if (!$user) {
                Response::json(400, [], ["success" => false, "error" => "Mauvaise donnée envoyé"]);
                return;
            }
            if ($user["role"] !== "ADMINISTRATOR") {
                Response::json(403, [], ["success" => false, "error" => "Mauvais role"]);
                return;
            }

            $statusCode = 200;

            $headers = [];

            $json = Request::json();

            UserModel::deleteOneById($json->id);

            $body = [
                "success" => "aucun problème"
            ];

            Response::json($statusCode, $headers, $body);
        } catch (PDOException $exception) {
            Response::json(500, [], ["success" => false, "error" => $exception->getMessage()]);
        }
    }
}
