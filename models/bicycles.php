<?php

include __DIR__ . "/../database/settings.php";

class BicyclesModel
{
    public static function getAll()
    {
        $databaseConnection = DatabaseSettings::getConnection();
        $query = $databaseConnection->query("SELECT * FROM bicycles");
        $todos = $query->fetchAll();

        return $todos;
    }
    
    public static function createOne($todo)
    {
        $databaseConnection = DatabaseSettings::getConnection();
        $query = $databaseConnection->prepare("INSERT INTO bicycles(brand, model, date) VALUES(:brand, :model, :date)");
        $query->execute($todo);
    }

    //create methode deleleteone by id

    public static function deleteOneById($id)
    { 
        $databaseConnection = DatabaseSettings::getConnection();
        $query = $databaseConnection->prepare("DELETE FROM bicycles WHERE id = :id");
        $query->execute(
            [
            "id" => $id
            ]
        );
    }

    //create methode updateone by id

    public static function updateOneById($id, $todo)
    {
        $set = [];
        $allowedKeys = ["brand", "model", "date"];

        foreach ($todo as $key => $value) {
            if (!in_array($key, $allowedKeys)) {
                continue;
            }

            $set[] = "$key = :$key";
        }

        $set = implode(", ", $set);
        $databaseConnection = DatabaseSettings::getConnection();
        $query = $databaseConnection->prepare("UPDATE bicycles SET $set WHERE id = :id");
        $query->execute(array_merge(["id" => $id], $todo));
    }
    

    public static function getOneByToken($token)
    {
        $databaseConnection = DatabaseSettings::getConnection();
        $query = $databaseConnection->prepare("SELECT * FROM users WHERE token = :token");

        $query->execute(
            [
            "token" => $token
            ]
        );

        $user = $query->fetch();

        return $user;
    }



    
}
