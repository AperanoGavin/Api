<?php

include __DIR__ . "/../database/settings.php";

class PostModel
{
    public static function getAll()
    {
        $databaseConnection = DatabaseSettings::getConnection(); 
        $query = $databaseConnection->query("SELECT * FROM posts");
        $posts = $query->fetchAll();

        return $posts;
    }

    public static function createOne($post)
    {
        $databaseConnection = DatabaseSettings::getConnection(); 
        $query = $databaseConnection->prepare("INSERT INTO posts(title, body, userId) VALUES(:title, :body, :userId)");
        $query->execute($post);
    }
}
