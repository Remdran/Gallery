;<?php


class Db_Object
{

    public static function findAllUsers()
    {
        return self::doQuery('SELECT * FROM ' . static::$dbTable); //late static binding
    }

    public static function doQuery($sql)
    {
        global $database;

        $result = $database->query($sql);
        $objArray = [];

        while ($row = mysqli_fetch_array($result)) {
            $objArray[] = self::Instantiate($row);
        }

        return $objArray;
    }

    public static function Instantiate($object)
    {
        $callingClass = get_called_class();
        $createdObject = new $callingClass;
        $class_props = get_object_vars($createdObject);

        foreach ($object as $property => $value) {
            if (array_key_exists($property, $class_props)) {
                $createdObject->$property = $value;
            }
        }

        return $createdObject;
    }

    public static function findUserById($id)
    {
        $resultArray = self::doQuery('SELECT * FROM ' . static::$dbTable . ' WHERE id = $id LIMIT 1');

        return ! empty($resultArray) ? array_shift($resultArray) : false;
    }
}