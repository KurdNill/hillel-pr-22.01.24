<?php

namespace Core;

use PDO;
class DB
{
    static protected ?PDO $instance = null;

    static public function connect(): PDO
    {
        if (!isset(self::$instance)) {
            //$dsn = 'mysql:host=mysql_db;dbname=php_advanced;port=3306;charset=utf8mb4';
            $dsn = 'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'). ';port=3306;charset=utf8mb4';
            $options = [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];

            //self::$instance = new PDO($dsn, 'root', 'secret', $options);
            self::$instance = new PDO($dsn, getenv('DB_USER'), getenv('DB_PASSWORD'), $options);
            //self::$instance = null; щоб закрити з'єднання
        }

        return self::$instance;
    }
}