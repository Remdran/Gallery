<?php
require_once("new_config.php");

class Database
{

    public $connection;
    public $db;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $this->db = $this->openDBConn();
    }

    public function openDBConn()
    {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->connection->connect_errno) {
            die("Database connection failed");
        }

        return $this->connection;
    }

    public function query($sql)
    {
        $result = $this->db->query($sql);

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
        return $this->db->real_escape_string($string);
    }

    public function insertedId()
    {
        return $this->db->insert_id;
    }
}

$database = new Database();


