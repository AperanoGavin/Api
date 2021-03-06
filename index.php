<?php

/**
 * Permet d'afficher constamment toutes les erreurs (même les masquées)
 *
 * @see https://www.php.net/manual/en/function.ini-set.php
 */

ini_set("display_errors", 1);

/**
 * Permet d'afficher tous les types d'erreurs (warnings, info, erreurs, ...)
 *
 * @see https://www.php.net/manual/en/function.error-reporting.php
 */
error_reporting(E_ALL);

/**
 * Permet d'ajouter un en-tête à la réponse
 *
 * @see https://www.php.net/manual/en/function.header.php
 */
header("Content-Type: text/plain");

/**
 * Modifier le code de statut de la réponse
 *
 * @see https://www.php.net/manual/en/function.http-response-code.php
 */
http_response_code(200);

/**
 * La route que l'utilisateur essaie de récupérer
 *
 * @see https://www.php.net/manual/en/reserved.variables.request.php
 */
$route = isset($_REQUEST["route"]) ? $_REQUEST["route"] : "";

/**
 * La méthode HTTP
 *
 * @see https://www.php.net/manual/en/reserved.variables.server.php
 */
$method = $_SERVER["REQUEST_METHOD"];

if ($route === "login") {
    include "./controllers/login.php";

    if ($method === "POST") {
        LoginController::post();
        return;
    }

    if ($method === "DELETE") {
        LoginController::delete();
        return;
    }
}

if ($route === "users") {
    include "./controllers/users.php";

    if ($method === "GET") {
        UserController::get();
        return;
    }
    
    if ($method === "POST") {
        UserController::post();
        return;
    }
    if ($method === "PATCH") {
            UserController::patch();
            return;
        }

   if ($method === "DELETE") {
            UserController::delete();
            return;
        }
}




if ($route === "bicycles") {
    include "./controllers/bicycles.php";

    if ($method === "GET") {
        MotorController::get();
        die();
    }

    if ($method === "POST") {
        MotorController::post();
        die();
    }
    if ($method === "DELETE") {
        MotorController::delete();
        die();
    }
    if ($method === "PATCH") {
        MotorController::patch();
        die();
    }
}

if ($route === "parts") {
    include "./controllers/parts.php";

    if ($method === "GET") {
        PartsController::get();
        die();
    }

    if ($method === "POST") {
        PartsController::post();
        die();
    }
    if ($method === "DELETE") {
        PartsController::delete();
        die();
    }
    if ($method === "PATCH") {
        PartsController::patch();
        die();
    }
}


require "./controllers/not-found.php";

NotFoundController::all();
