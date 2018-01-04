<?php


class User extends Db_Object
{
    protected $id;
    protected $username;
    protected $password;
    protected $first_name;
    protected $last_name;
    protected $user_image;
    protected $uploadDir = "images";
    protected $imagePlaceholder = "http://placehold.it/400x400&text=image";
    protected static $dbTable = "users";

    public static function verifyUser($username, $password)
    {
        global $database;

        $username = $database->escapeString($username);
        $password = $database->escapeString($password);

        $sql = "SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' LIMIT 1";

        $result = self::doQuery($sql);
        return ! empty($result) ? array_shift($result) : false;
    }

    public function save()
    {
        return isset($this->id) ? $this->update() : $this->create();
    }

    public function create()
    {
        global $database;

        $sql = "INSERT INTO " . static::$dbTable . " (username, password, first_name, last_name, user_image) VALUES ('";
        $sql .= $database->escapeString($this->username) . "', '";
        $sql .= $database->escapeString($this->password) . "', '";
        $sql .= $database->escapeString($this->first_name) . "', '";
        $sql .= $database->escapeString($this->last_name) . "', '";
        $sql .= $database->escapeString($this->user_image) . "')";

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

        $sql = "UPDATE " . static::$dbTable . " SET ";
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

        $sql = "DELETE FROM " . static::$dbTable;
        $sql .= " WHERE id=" . $database->escapeString($this->id);
        $sql .= " LIMIT 1";

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    public function imagePath()
    {
        return empty($this->user_image) ? $this->imagePlaceholder : $this->uploadDir . DS . $this->user_image;
    }

    public function saveImage()
    {
        if ( ! empty($this->errors)) {
            return false;
        }

        if (empty($this->user_image) || empty($this->tmpPath)) {
            $this->errors[] = "The file was not available";
            return false;
        }

        $targetPath = DS . 'home' . DS . 'kel' . DS . SITE_ROOT . DS . 'admin' . DS . $this->uploadDir . DS . $this->user_image;

        var_dump($targetPath);

        if (file_exists($targetPath)) {
            $this->errors[] = "The file {$this->user_image} already exists";
            return false;
        }

        if (move_uploaded_file($this->tmpPath, $targetPath)) {
            unset($this->tmpPath);
            return true;
        } else {
            $this->errors[] = "The images folder has a problem with its permissions";
            return false;
        }
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

    public function getUserImage()
    {
        return $this->user_image;
    }

    public function getPassword()
    {
        return $this->password;
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

    public function setUserImage($user_image)
    {
        $this->user_image = $user_image;
    }
    //endregion
}