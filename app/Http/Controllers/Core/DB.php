<?php

namespace app\Http\Controllers\Core;

use PDO;

class DB
{
    protected $connection;
    protected $query;

    public $columns = array();
    public $table;
    public $where;
    public $limit;

    public function __construct()
    {
        $this->connection = new PDO("mysql:host=".getenv('db_host').";dbname=".getenv('db_name'), getenv('db_username'), getenv('db_password'));
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function __destruct()
    {
        $this->connection = null;
    }

    public function select($columns)
    {
        $this->columns = $columns;
        return $this;
    }
    public function from($table)
    {
        $this->table = $table;
        return $this;
    }
    public function where($where)
    {
        $this->where = $where;
        return $this;
    }
    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function get() {
        $selectedColumns = '*';
        if($this->columns) $selectedColumns = implode(', ', $this->columns);
        $query = 'select '. $selectedColumns. ' from ' . $this->table . ($this->where ? ' where ': '') . ($this->limit ? ' limit ': '');
        $this->query = $this->connection->query($query);
        return $this->query->fetchAll();
    }

}