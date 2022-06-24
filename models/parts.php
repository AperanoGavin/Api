<?php

include __DIR__ . "/../database/settings.php";

class  PartsModel
{
    public static function getAll()
    {
        $databaseConnection = DatabaseSettings::getConnection();
        $query = $databaseConnection->query("SELECT * FROM  parts");
        $todos = $query->fetchAll();

        return $todos;
    }
    
   
    public static function createOne($rooms)
    {
        $databaseConnection = DatabaseSettings::getConnection();
        $query = $databaseConnection->prepare("INSERT INTO parts(date, amount, bicycle, owner) VALUES(:date, :amount , :bicycle , :owner)");
        $query->execute($rooms);
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

    public static function deleteOneById($id)
    { 
        $databaseConnection = DatabaseSettings::getConnection();
        $query = $databaseConnection->prepare("DELETE FROM parts  WHERE id = :id");
        $query->execute(
            [
            "id" => $id
            ]
        );
    }

    public static function updateOneById($id, $rooms)
    {
        $set = [];
        $allowedKeys = ["date", "amount" , "bicycle" , "owner"];

        foreach ($rooms as $key => $value) {
            if (!in_array($key, $allowedKeys)) {
                continue;
            }

            $set[] = "$key = :$key";
        }

        $set = implode(", ", $set);
        $databaseConnection = DatabaseSettings::getConnection();
        $query = $databaseConnection->prepare("UPDATE parts SET $set WHERE id = :id");
        $query->execute(array_merge(["id" => $id], $rooms));
    }



    
}
