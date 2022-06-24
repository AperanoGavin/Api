<?php

class DatabaseSettings
{
    static $driver = "mysql";
    static $name = "esgi-webapi-2a1-2022";
    static $host = "localhost";
    static $user = "root";
    static $password = "root";

    static $pdoSettings = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    public static function getConnection()
    {
        $driver = DatabaseSettings::$driver;
        $databaseName = DatabaseSettings::$name;
        $host = DatabaseSettings::$host;
        $user = DatabaseSettings::$user;
        $password = DatabaseSettings::$password;

        return new PDO("$driver:dbname=$databaseName;host=$host", $user, $password, DatabaseSettings::$pdoSettings);
    }
}
