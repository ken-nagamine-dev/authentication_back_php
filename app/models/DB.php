<?php
namespace app\models;

use \PDO;

$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__FILE__, 3));
$dotenv->load();

class DB
{
    public static function connect()
    {
        $conn_str = $_ENV['DB_DRIVER'].':host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_NAME'];
        $conn = new PDO($conn_str, $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
}