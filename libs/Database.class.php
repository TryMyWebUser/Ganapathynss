<?php

class Database
{
    public static $conn = null;

    public static function getConnect()
    {
        if (Database::$conn == null)
        {
            $server = "localhost";
            $username = "root";
            $password = "";
            $dbname = "ganapathynss";
            // $server = "localhost";
            // $username = "trymywebsites_nss";
            // $password = "nss@2025";
            // $dbname = "trymywebsites_nss";

            // create connection
            $connection = new mysqli($server, $username, $password, $dbname);

            if ($connection->connect_error)
            {
                die("Connection Failed: " . $connection->connect_error);
            }
            else
            {
                Database::$conn = $connection;
                return Database::$conn;
            }
        }
        return Database::$conn; // Return the connection here.
    }
}

?>