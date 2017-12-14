<?php


class User
{

    protected $id;
    protected $username;
    protected $password;
    protected $first_name;
    protected $last_name;


    public static function findAllUsers()
    {
        return self::doQuery('SELECT * FROM users');
    }

    public static function doQuery($sql)
    {
        global $database;

        $result = $database->query($sql);
        $objArray = [];

        while ($row = mysqli_fetch_array($result)) {
            $objArray[] = self::createUser($row);
        }

        return $objArray;
    }

    public static function createUser($user)
    {
        $createdUser = new self;
        $class_props = get_object_vars($createdUser);

        foreach ($user as $property => $value) {
            if (array_key_exists($property, $class_props)) {
                $createdUser->$property = $value;
            }
        }

        return $createdUser;
    }

    public static function findUserById($id)
    {
        $resultArray = self::doQuery("SELECT * FROM users WHERE id = $id LIMIT 1");

        return ! empty($resultArray) ? array_shift($resultArray) : false;
    }

    public static function verifyUser($username, $password)
    {
        global $database;

        $username = $database->escapeString($username);
        $password = $database->escapeString($password);

        $sql = "SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' LIMIT 1";

        $result = self::doQuery($sql);
        return ! empty($result) ? array_shift($result) : false;
    }

    public function create($username, $password, $first_name, $last_name)
    {
        global $database;

        $sql = "INSERT INTO users (username, password, first_name, last_name) VALUES ('";
        $sql .= $database->escapeString($username) . "', '";
        $sql .= $database->escapeString($password) . "', '";
        $sql .= $database->escapeString($first_name) . "', '";
        $sql .= $database->escapeString($last_name) . "')";

        if ($database->query($sql)) {
            $this->id = $database->insertedId();
            return true;
        } else {
            return false;
        }
    }

    public function update()
    {
        global $database;

        $sql = "UPDATE users SET ";
        $sql .= "username= '" . $database->escapeString($this->username) . "', ";
        $sql .= "password= '" . $database->escapeString($this->password) . "', ";
        $sql .= "first_name= '" . $database->escapeString($this->first_name) . "', ";
        $sql .= "last_name= '" . $database->escapeString($this->last_name) . "' ";
        $sql .= " WHERE id= " . $database->escapeString($this->id);

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    public function delete()
    {
        global $database;

        $sql = "DELETE FROM users ";
        $sql .= "WHERE id=" . $database->escapeString($this->id);
        $sql .= " LIMIT 1";

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }


    //region Getters

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }
    //endregion

    //region Setters
    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }
    //endregion
}