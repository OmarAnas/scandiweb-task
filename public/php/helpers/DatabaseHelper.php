<?php

class DatabaseHelper
{
    private $db;
    private $stmt;
    private $query;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /*
    *   query builder methods
    */
    public function select($columns)
    {
        $this->query = "SELECT {$columns}";
        return $this;
    }

    public function insert($tablename, $data)
    {
        $columns = implode(',', $data);
        $placeholders = ':' . implode(', :', $data);

        $this->query = "INSERT INTO {$tablename} ({$columns}) VALUES ({$placeholders})";
        return $this;
    }

    public function delete()
    {
        $this->query = "DELETE";

        return $this;
    }

    public function from($tablename)
    {
        $this->query .= " FROM {$tablename}";
        return $this;
    }

    public function where($column, $operator, $value)
    {
        $this->query .= " WHERE {$column} {$operator} ({$value})";
        return $this;
    }


    /*
    *   statements methods (pdo methods)
    */
    public function query()
    {
        $this->stmt = $this->db->prepare($this->query);
        return $this;
    }


    public function bind($data)
    {
        foreach ($data as $param => $value) {
            $this->stmt->bindValue(":".$param, $value);
        }
        return $this;
    }


    public function execute($arr = null)
    {
        $this->stmt->execute($arr);

        return $this;
    }


    public function multipleResults()
    {
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function singleResult()
    {
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

}
