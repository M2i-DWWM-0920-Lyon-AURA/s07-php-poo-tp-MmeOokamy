<?php

namespace App\Core;

final class DatabaseHandler
{
    

    /**
     * @static
     * @var \PDO $instance Current instance of PDO
     */
    static private $instance;

    private function __construct() { }


    /**
     * Get current instance of PDO
     * 
     * @static
     */
    static private function getInstance(): \PDO
    {
        if (is_null(static::$instance)) {
            $pdo = new \PDO('mysql:host=localhost;dbname=php-todos', 'root', 'root');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);

            static::$instance = $pdo;
        }

        return static::$instance;
    }



    /**
     * Send SQL request to database
     * 
     * @static
     * @param string $sqlQuery SQL query to be sent
     * @return \PDOStatement
     */
    static public function query(string $sqlQuery): \PDOStatement
    {
        return static::getInstance()->query($sqlQuery);
    }

    /**
     * Create prepared request before sending it to database
     * 
     * @static
     * @param string $sqlQuery SQL query to be sent
     * @return \PDOStatement
     */
    static public function prepare(string $sqlQuery): \PDOStatement
    {
        return static::getInstance()->prepare($sqlQuery);
    }

    /**
     * Get last inserted ID in database
     * 
     * @static
     * @return int
     */
    static public function lastInsertId(): int
    {
        return static::getInstance()->lastInsertId();
    }
}
