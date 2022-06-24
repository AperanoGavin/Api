<?php

include __DIR__ . "/../library/response.php";
include __DIR__ . "/../models/parts.php";
include __DIR__ . "/../library/request.php";

class  PartsController
{
    public static function get()
    {
        try {
            $headers = Request::headers();
            
            
            if (!isset($headers["token"])) {
                Response::json(401, [], ["success" => false, "error" => " pas de jeton d’authentification ou incorrect ou inexistant"]);
                return;
            }

            $user = PartsModel::getOneByToken($headers["token"]);

            if (!$user) {
                Response::json(400, [], ["success" => false, "error" => "mauvaises données envoyées"]);
                return;
            }
            if ($user["role"] !== "ADMINISTRATOR") {
                Response::json(403, [], ["success" => false, "error" => "mauvais rôle"]);
                return;
            } 

            $statusCode = 200;

            $headers = [];

            $todos = PartsModel::getAll();

            $body = [
                "success" => "aucun problème",
                "todos" => $todos
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

            $user = PartsModel::getOneByToken($headers["token"]);

            if (!$user) {
                Response::json(400, [], ["success" => false, "error" => "mauvaises données envoyées"]);
                return;
            }
            if ($user["role"] !== "ADMINISTRATOR") {
                Response::json(403, [], ["success" => false, "error" => "mauvais rôle"]);
                return;
            } 


            $statusCode = 200;

            $headers = [];

            $json = Request::json();

            PartsModel::createOne([
                "date" => $json-> date,
                "amount" => $json->amount,
                "bicycle" => $json->bicycle,
                "owner" => $json->owner,
            ]);

            $body = [
                "success" => "aucun problème"
            ];

            Response::json($statusCode, $headers, $body);
        } catch (PDOException $exception) {
            Response::json(500, [], ["success" => false, "error" => $exception->getMessage()]);
        }
    }
    //create public static function  delete() with Todomodel::deleteOneTodosById($id)
    public static function delete()
    {
        try {


            $headers = Request::headers();
            
            
            if (!isset($headers["token"])) {
                Response::json(401, [], ["success" => false, "error" => " pas de jeton d’authentification ou incorrect ou inexistant"]);
                return;
            }

            $user = PartsModel::getOneByToken($headers["token"]);

            if (!$user) {
                Response::json(400, [], ["success" => false, "error" => "mauvaises données envoyées"]);
                return;
            }
            if ($user["role"] !== "ADMINISTRATOR") {
                Response::json(403, [], ["success" => false, "error" => "mauvais rôle"]);
                return;
            } 

            $statusCode = 200;

            $headers = [];

            $json = Request::json();

            PartsModel::deleteOneById($json->id);

            $body = [
                "success" => "aucun problème"
            ];

            Response::json($statusCode, $headers, $body);
        } catch (PDOException $exception) {
            Response::json(500, [], ["success" => false, "error" => $exception->getMessage()]);
        }
    }

    //create public static function  patch()with Todomodel::updateOneTodosById($id, $todo)
    public static function patch()
    {
        try {
            $headers = Request::headers();
            
            
            if (!isset($headers["token"])) {
                Response::json(401, [], ["success" => false, "error" => " pas de jeton d’authentification ou incorrect ou inexistant"]);
                return;
            }

            $user = PartsModel::getOneByToken($headers["token"]);

            if (!$user) {
                Response::json(400, [], ["success" => false, "error" => "mauvaises données envoyées"]);
                return;
            }
            if ($user["role"] !== "ADMINISTRATOR") {
                Response::json(403, [], ["success" => false, "error" => "mauvais rôle"]);
                return;
            } 

            $json = Request::json();

            $statusCode = 200;

            $headers = [];

            $rooms_id = $json->id;
            $json_array = (array) $json;

            PartsModel::updateOneById($rooms_id, $json_array);

            $body = [
                "success" => "aucun problème"
            ];

            Response::json($statusCode, $headers, $body);
        } catch (PDOException $exception) {
            Response::json(500, [], ["success" => false, "error" => $exception->getMessage()]);
        }
    }
     


    
}
