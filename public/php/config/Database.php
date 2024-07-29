<?php

class Database
{
    private static $instance;

    private $config;
    private $host;
    private $user;
    private $pass;
    private $dbname;

    private $dbh;
    private $error;
    private $stmt;

    private function __construct()
    {
        $config = new Config();

        $this->host = DB_HOST;
        $this->user = DB_USER;
        $this->pass = DB_PASS;
        $this->dbname = DB_NAME;

        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    public static function getInstance()
    {
        if(self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->dbh;
    }

    private function __clone()
    {
    }
}
