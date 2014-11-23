<?php

class database
{
    public static function getConnection()
    {
        $db = null;

        $serverName = 'xxx';
        $dbName = 'xxx';
        $userName = 'xxx';
        $password = 'xxx';

        try
        {
            $db = new PDO("mysql:host=$serverName;dbname=$dbName;charset=utf8;unix_socket=/tmp/mysql.sock;", $userName, $password); //server
            //echo 'Connected successfully';
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }

        return $db;
    }
}
