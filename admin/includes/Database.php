<?php
require_once("new_config.php");

class Database
{

    public $connection;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $this->openDBConn();
    }


    public function openDBConn()
    {
//        $this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->connection->connect_errno) {
            die("Database connection failed");
        }
    }

    public function query($sql)
    {
        $result = $this->connection->query($sql);

        $this->confirm_query($result);

        return $result;
    }

    private function confirm_query($result)
    {
        if ( ! $result) {
            die("Query failed");
        }
    }

    public function escapeString($string)
    {
        return $this->connection->real_escape_string($string);
    }

    public function insertedId()
    {
        return $this->connection->insert_id;
    }
}

$database = new Database();


