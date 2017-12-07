<?php


class User
{

    public $id;
    public $username;
    public $first_name;
    public $last_name;

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
        return self::doQuery("SELECT * FROM users WHERE id = $id");
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

}